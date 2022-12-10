    @component('admin.component.select', [
        'name' => 'festival_category_id',
        'title' => 'Select Festival Category',
        'lists' => \App\Models\FestivalCategory::get()->pluck('name','id'),
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Select Festival Category','id'=>"festival_category_id"]
    ])@endcomponent
    @component('admin.component.select', [
        'name' => 'festival_sub_category_id',
        'title' => 'Select Sub Category',
        'lists' => App\Models\FestivalSubCategory::where('festival_category_id',$record['festival_category_id']??'')->pluck('name','id'),
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Select Sub Category ','id'=>"festival_sub_category_id"]
    ])@endcomponent
    @component('admin.component.select', [
        'name' => 'festival_peta_category_id',
        'title' => 'Select Peta Category',
        'lists' => App\Models\FestivalPetaCategory::where('festival_sub_category_id',$record['festival_sub_category_id']??'')->pluck('name','id'),
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Select Peta Category ','id'=>"festival_peta_category_id"]
    ])@endcomponent
    @component('admin.component.text', [
        'name' => 'title',
        'title' => 'Title',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter title']
    ])@endcomponent
    @component('admin.component.text', [
       'name' => 'description',
       'title' => 'Description',
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Enter description']
   ])@endcomponent
    @component('admin.component.select', [
       'name' => 'language',
       'title' => 'Select Language',
       'lists' => \App\Models\VideoCategory::$languages,
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Select language']
   ])@endcomponent
    @component('admin.component.file', [
        'name' => 'media',
        'title' => 'Upload Media',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Choose file']
    ])@endcomponent

    @component('admin.component.select', [
       'name' => 'media_type',
       'title' => 'Select Media Type (Image/Vidoe)',
       'lists' =>['image'=>'Image','video'=>'Video'],
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Select Media Type']
   ])@endcomponent
   
   <div class="form-group">
    <label class="control-label mb-4">Select Apps<span class="text-danger">*</span></label> <br>

    @foreach (\App\Models\App::get() as $item)
        <label class="control-label mr-5">{{ $item->name }}:
            {!! Form::checkbox('app_ids[]',$item->id, $item->festivalPetaCategory()->find($record['id']??0),['class' => 'form-contro mt-2'] ) !!}
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
