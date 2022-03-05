  
  @extends('layouts.dashboard')

@section('content')
          <!--main content start-->
       
          
    <section id="main-content">
        <section class="wrapper">
          <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header"><i class="fa fa-user-md"></i> Forum Settings</h3>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
                <li><i class="fa fa-users"></i>Settings</li>
              <li><i class="fa fa-user-md"></i></li>
              </ol>
            </div>
          </div>


          <!-- edit-profile -->
<div id="edit-profile" class="tab-pane">
  <section class="panel">
    <div class="panel-body bio-graph-info">
      <h1> Settings</h1>
      <form class="form-horizontal" action="{{route('settings.new')}}" method="POST">
        @csrf
      <div class="form-group">
          <label class="col-lg-2 control-label">Forum Name</label>
          <div class="col-lg-6">
            <input type="text" class="form-control" name="forum_name" placeholder=" ">
          </div>
        </div>
        

        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>


        </section>
      </section>
      <!--main content end-->
      
@endsection












