@component('admin.component.text', [
    'name' => 'first_name',
    'title' => 'First Name',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter First Name']
])@endcomponent
@component('admin.component.text', [
    'name' => 'last_name',
    'title' => 'Last Name',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Last Name']
])@endcomponent
@component('admin.component.text', [
    'name' => 'username',
    'title' => 'Username',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Username']
])@endcomponent
@component('admin.component.text', [
    'name' => 'email',
    'title' => 'Email',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter email']
])@endcomponent
@component('admin.component.password', [
    'name' => 'password',
    'title' => 'Password',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter password']
])@endcomponent
@component('admin.component.text', [
    'name' => 'contact',
    'title' => 'Contact',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter contact']
])@endcomponent

{{--@component('admin.component.text', [--}}
{{--'name' => 'business',--}}
{{--'title' => 'Business',--}}
{{--'value'=>null,--}}
{{--'required'=>true,--}}
{{--'options'=>['placeholder'=>'Enter business']--}}
{{--])@endcomponent--}}

@component('admin.component.select', [
    'name' => 'gender',
    'title' => 'Gender',
    'lists' => ['Male'=>'Male','Female'=>'Female'],
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Select Gender']
])@endcomponent

@component('admin.component.text', [
    'name' => 'country',
    'title' => 'Country',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Country']
])@endcomponent
@component('admin.component.text', [
    'name' => 'state',
    'title' => 'State',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter State']
])@endcomponent
@component('admin.component.text', [
    'name' => 'taluka',
    'title' => 'Taluka',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter Taluka']
])@endcomponent
@component('admin.component.text', [
    'name' => 'city',
    'title' => 'City',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter City']
])@endcomponent


@component('admin.component.select', [
    'name' => 'business',
    'title' => 'Business',
    'lists' => \App\Models\Business::get()->pluck('name','name'),
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Enter business']
])@endcomponent

@component('admin.component.file', [
    'name' => 'image',
    'title' => 'profile Image',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Choose image']
])@endcomponent


@component('admin.component.select', [
    'name' => 'app_id',
    'title' => 'App',
    'lists' => \App\Models\App::get()->pluck('name','id'),
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Select App ']
])@endcomponent

@if(!empty($record['image_url']))
    <img src="{{ $record['image_url'] }}" width="150">
@endif

