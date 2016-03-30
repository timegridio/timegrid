<!-- search form (Optional) -->
{!! Form::open(['method' => 'post', 'url' => route('manager.search', $business), 'class' => 'sidebar-form', 'role' => 'search']) !!}
<div class="input-group">
    <input type="text" name="criteria" id="search" class="form-control" placeholder="{{trans('app.search.placeholder')}}">
    <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
        </button>
    </span>
</div>
{!! Form::close() !!}
<!-- /.search form -->