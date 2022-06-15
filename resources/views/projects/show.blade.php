@extends('layouts.app')

@section('content')
<div class = 'container'>
  <h3>案件名:{{ $project->project_name }}</h3>
  <h3>案件概要:{{ $project->outline }}</h3>
  <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">{{ $project->project_name }}設計書PDF</a>
  <p>担当グループ:{{ $project->group->group_name }}</p>

</div>

@endsection

