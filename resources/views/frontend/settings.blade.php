@extends('layouts.app')

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
  <div class='container'>

    @if (isset($greeting))
      <div class='alert alert-primary' role='alert'>{{ $greeting }}</div>
    @elseif(isset($failing))
      <div class='alert alert-danger' role='alert'>{{ $failing }}</div>
    @endif

    <h1>Setting</h1>

    {{ Form::open(['url' => route('settings.mail.save')]) }}

    @foreach ($mailCategories as $mailCategory)
      {{ Form::hidden($mailCategory->name . '[is_received]', 0) }}
      {{ Form::checkbox(
          $mailCategory->name . '[is_received]',
          '1',
          old($mailCategory->name, $user->isReceivedMailByMailCategoryId($mailCategory->id)),
          ['id' => $mailCategory->name, 'class' => 'form-check-input'],
      ) }}
      {{ Form::label($mailCategory->name, $mailCategory->annotation) }}

      @if ($mailCategory->hasDays())
        @php
          $noticeNumberDays = $user->getMailSettingNoticeNumberDaysByMailCategoryId($mailCategory->id);
        @endphp

        {{ Form::number($mailCategory->name . '[notice_number_days]', old('notice_number_days', $noticeNumberDays), [
            'placeholder' => '1',
            'id' => 'notice_number_days',
            'class' => 'form-control w-25 d-inline',
        ]) }}
        Days ago
      @endif

      <br>
    @endforeach

    <br>
    {{ Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary']) }}

    {{ Form::close() }}

    <br>
    <hr>
    {{ Form::open(['url' => route('settings.general.save')]) }}

    @foreach ($generalSettingCategories as $generalSettingCategory)
      {{ Form::hidden($generalSettingCategory->name, 0) }}
      {{ Form::checkbox(
          $generalSettingCategory->name,
          '1',
          old($generalSettingCategory->name, $user->enableGeneralSettingByGeneralId($generalSettingCategory->id)),
          ['id' => $generalSettingCategory->name, 'class' => 'form-check-input'],
      ) }}
      {{ Form::label($generalSettingCategory->name, $generalSettingCategory->annotation) }}

      <br>
    @endforeach

    <br>
    {{ Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary']) }}

    {{ Form::close() }}
  </div>
@endsection
