    @component('admin.component.select', [
        'name' => 'festival_category_id',
        'title' => 'Select Festival Category',
        'lists' => \App\Models\FestivalCategory::get()->pluck('name','id'),
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Select Festival Category','id'=>"festival_category_id"]
    ])@endcomponent
    @component('admin.component.text', [
        'name' => 'name',
        'title' => 'Name',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter name']
    ])@endcomponent

    @component('admin.component.datepicker', [
        'name' => 'festival_date',
        'title' => 'Festival date',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter festival date']
    ])@endcomponent

    @component('admin.component.datepicker', [
        'name' => 'active_from',
        'title' => 'Active form date',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter name']
    ])@endcomponent


    @component('admin.component.file', [
        'name' => 'image',
        'title' => 'Upload image',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Choose file']
    ])@endcomponent
    
    <div class="form-group">
        <label class="control-label mb-4">Select Apps<span class="text-danger">*</span></label> <br>

        @foreach (\App\Models\App::get() as $item)
            <label class="control-label mr-5">{{ $item->name }}:
                {!! Form::checkbox('app_ids[]',$item->id, $item->festivalSubCategory()->find($record['id']??0),['class' => 'form-contro mt-2'] ) !!}
            </label>
        @endforeach
    </div>
   
    <div class="form-group">
        <label class="control-label">Display Order </label>
        {!! Form::number('display_order',null, ['class' => 'form-control'] ) !!}
        {{--<span class="help-block" id="error_{{ $name }}"><strong>{{ $errors->first($name) }}</strong></span>--}}
    </div>
    @if(!empty($record['image_url']))
    <img src="{{ $record['image_url'] }}" width="150">
    @endif

