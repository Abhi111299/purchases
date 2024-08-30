<option value="">Select</option>
@foreach($models as $model)
<option value="{{ $model->model_id }}">{{ $model->model_name }}</option>
@endforeach