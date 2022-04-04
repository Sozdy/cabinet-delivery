@foreach($actions as $action)
    <option value="{{ $action->id }}">{{ $action->name }}</option>
@endforeach
