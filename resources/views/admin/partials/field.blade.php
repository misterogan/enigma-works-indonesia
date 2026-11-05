@php
  $type = $field['type'] ?? 'text';
  $name = $field['name'];
  $formValue = old($name, \App\Support\Admin\FieldMapper::toForm($field, $value));
@endphp
<div class="field">
  @if ($type === 'boolean')
    <label class="check"><input type="hidden" name="{{ $name }}" value="0"><input type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $value))> {{ $field['label'] }}</label>
  @else
    <label for="f_{{ $name }}">{{ $field['label'] }}</label>
    @switch($type)
      @case('textarea')
        <textarea id="f_{{ $name }}" name="{{ $name }}">{{ $formValue }}</textarea>
        @break
      @case('markdown')
        <textarea id="f_{{ $name }}" name="{{ $name }}" class="md">{{ $formValue }}</textarea>
        @break
      @case('lines')
        <textarea id="f_{{ $name }}" name="{{ $name }}" placeholder="Satu item per baris">{{ $formValue }}</textarea>
        @break
      @case('pairs')
        <textarea id="f_{{ $name }}" name="{{ $name }}" placeholder="Judul | Penjelasan (satu per baris)">{{ $formValue }}</textarea>
        @break
      @case('number')
        <input id="f_{{ $name }}" type="number" name="{{ $name }}" value="{{ $formValue }}">
        @break
      @case('datetime')
        <input id="f_{{ $name }}" type="datetime-local" name="{{ $name }}" value="{{ $formValue }}">
        @break
      @case('select')
        <select id="f_{{ $name }}" name="{{ $name }}">
          @foreach ($field['options'] as $optValue => $optLabel)
            <option value="{{ $optValue }}" @selected((string) $formValue === (string) $optValue)>{{ $optLabel }}</option>
          @endforeach
        </select>
        @break
      @case('image')
        @if ($value)
          <img src="{{ \App\Support\Media::url($value) }}" alt="" class="thumb">
          <label class="check" style="font-weight:500"><input type="checkbox" name="{{ $name }}__remove" value="1"> Hapus gambar</label>
        @endif
        <input id="f_{{ $name }}" type="file" name="{{ $name }}" accept="image/*">
        @break
      @default
        <input id="f_{{ $name }}" type="text" name="{{ $name }}" value="{{ $formValue }}">
    @endswitch
  @endif
  @if (! empty($field['help']))<span class="help">{{ $field['help'] }}</span>@endif
</div>
