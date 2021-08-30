@foreach($options as $option)
    <option {{ $option === $selected ? 'selected' : '' }}>{{ $option }}</option>
@endforeach
