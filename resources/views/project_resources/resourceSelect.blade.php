<div>
  <h1>案件利用資材</h1>
  <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">{{ $project->project_name }}設計書PDF</a>

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <form action="/project/{{ $project->id }}/task_charges/project_resources/resourceSelect" method="post">
    @csrf

    @for($i = 0 ; $i < 10; $i ++)
      <label for="project_resource[{{ $i }}][resource]">利用資材{{ $i + 1}}</label>
      <select name="project_resource[{{ $i }}][resource]" >
          <option value="">-</option>
        @foreach($resources as $resource)
            <option value="{{ $resource->id }}" @if(old("project_resource.$i.resource") == $resource->id || old("$i.resource") == $resource->id) selected @endif>{{ $resource->resource_name }}</option>
        @endforeach
      </select></br>

      <label for="project_resource[{{ $i }}][consumption_quantity]">使用数</label>
      <input name="project_resource[{{ $i }}][consumption_quantity]" value="{{ old("project_resource.$i.consumption_quantity") || old("$i.consumption_quantity") }}"></br></br>
    @endfor
    
      <input type="hidden" name="project_id" value="{{ $project->id }}">
      <input type="submit" value="進行計画登録画面へ">
  </form>
</div>