<?php

namespace App\Support\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Mengubah nilai form backoffice menjadi data yang disimpan, dan sebaliknya.
 */
class FieldMapper
{
    /** Nilai dari request -> nilai untuk disimpan. */
    public static function fromRequest(array $field, Request $request, $current = null)
    {
        $name = $field['name'];
        $type = $field['type'] ?? 'text';
        $raw = $request->input($name);

        switch ($type) {
            case 'boolean':
                return $request->boolean($name);

            case 'number':
                return (int) $raw;

            case 'tags':
                return array_values(array_filter(array_map('trim', explode(',', (string) $raw))));

            case 'lines':
                return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $raw))));

            case 'pairs':
                $lines = array_filter(array_map('trim', preg_split('/\R/', (string) $raw)));

                return array_values(array_map(function ($line) {
                    $parts = array_map('trim', explode('|', $line, 2));

                    return [$parts[0], $parts[1] ?? ''];
                }, $lines));

            case 'datetime':
                return $raw ? Carbon::parse($raw) : null;

            case 'image':
                if ($request->boolean($name.'__remove')) {
                    if ($current) {
                        Storage::disk('public')->delete($current);
                    }

                    return null;
                }
                if ($request->hasFile($name)) {
                    if ($current) {
                        Storage::disk('public')->delete($current);
                    }

                    return $request->file($name)->store('uploads', 'public');
                }

                return $current;

            default:
                return $raw;
        }
    }

    /** Nilai tersimpan -> teks untuk ditampilkan di form. */
    public static function toForm(array $field, $value): string
    {
        $type = $field['type'] ?? 'text';

        if ($type === 'tags') {
            return implode(', ', (array) $value);
        }
        if ($type === 'lines') {
            return implode("\n", (array) $value);
        }
        if ($type === 'pairs') {
            return implode("\n", array_map(fn ($p) => trim(($p[0] ?? '').' | '.($p[1] ?? '')), (array) $value));
        }
        if ($type === 'datetime') {
            return $value ? Carbon::parse($value)->format('Y-m-d\TH:i') : '';
        }

        return (string) ($value ?? '');
    }

    public static function rules(array $fields): array
    {
        $rules = [];
        foreach ($fields as $field) {
            $type = $field['type'] ?? 'text';
            if ($type === 'image') {
                $rules[$field['name']] = 'nullable|image|max:4096';
            } elseif ($type === 'boolean') {
                continue;
            } else {
                $rules[$field['name']] = $field['rules'] ?? 'nullable';
            }
        }

        return $rules;
    }
}
