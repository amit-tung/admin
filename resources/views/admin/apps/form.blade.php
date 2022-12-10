@component('admin.component.text', [
    'name' => 'name',
    'title' => 'App Name',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter App Name']
])@endcomponent
{{-- @component('admin.component.text', [
    'name' => 'route',
    'title' => 'App Route',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter App Route']
])@endcomponent --}}
@component('admin.component.text', [
    'name' => 'package_id',
    'title' => 'App Package Id',
    'value'=>null,
    'required'=>false,
    'options'=>['placeholder'=>'Enter Package Id']
])@endcomponent
