@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if ($user->image)
                        <img class="profile-user-img img-fluid img-circle"  src="{{asset('/storage/profile/'.$user->image)}}" alt="User profile picture">
                        @else
                        <img class="profile-user-img img-fluid img-circle"  src="{{asset('/images/profile.png')}}" alt="User profile picture"> 
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{$user->name}}</h3>

                   @if (auth()->id() ==$user->id ||auth()->user()->is_admin)
                   <p class="text-muted text-center">{{$user->email}}</p>  
                   @endif

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Topics Count:</b> <a class="float-right">{{count($user->topics)}}</a>
                        </li>
                        {{-- <li class="list-group-item">
                            <b>Following</b> <a class="float-right">543</a>
                        </li>
                        <li class="list-group-item">
                            <b>Friends</b> <a class="float-right">13,287</a>
                        </li> --}}
                    </ul>

                    <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Education</strong>

                    <p class="text-muted">
                        {{$user->education}}
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                    <p class="text-muted">{{$user->country}}</p>

                    <hr>

                    <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                    <p class="text-muted">
                        {{$user->skills}}
                    </p>

                    <hr>

                    <strong><i class="far fa-file-alt mr-1"></i> Bio</strong>

                    <p class="text-muted">{{$user->bio}}</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->


        <div class="col-md-9">


            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">

                               @if ($latest_user_post)
                                   <!-- Post -->
                            <div class="post">
                               <div class="user-block">
                                  @if ($user->image)
                                  <img class="img-circle img-bordered-sm" height="50" width="50" src="{{asset('/storage/profile/'.$user->image)}}" alt="user image">
                                  @else
                                  <img class="img-circle img-bordered-sm" height="50" width="50" src="{{asset('/images/profile.png')}}" alt="user image"> 
                                  @endif
                                   <span class="username">
                                       <a href="#">{{$user->name}}</a>
                                       <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                   </span>
                                   <span class="description">Started a discussion - {{$latest_user_post->created_at}}</span>
                               </div>
                               <!-- /.user-block -->
                              @if ($latest_user_post)
                              <p>
                               {{$latest_user_post->desc}}
                               </p>
                              @else
                              <p>
                               You have not started any discussion yet
                               </p> 
                              @endif

                               <p>
                                   <a href="#" class="link-black text-sm mr-2"><i class="fas fa-eye mr-1"></i>{{$latest_user_post->views}} views</a>
                                   <a href="#" class="link-black text-sm"><i class="fa fa-arrow-down mr-1"></i> {{$latest_user_post->replies->count()}}  replies</a>
                                   <span class="float-right">
                                       
                                       @if(auth()->user() && auth()->user()->is_admin)
                                       <a href="{{route('topic.delete', $latest_user_post->id)}}" class="link-black text-sm">
                                          <i class="fas fa-trash text-danger"></i>
                                      </a> 
                                       @endif
                                       
                                      
                                   </span>
                               </p>

                               <br><br>
                           </div>
                           <!-- /.post -->
                               @else
                                  @if (auth()->id() == $user->id)
                                  <h3>You have not started any discussion</h3> 
                                  @else
                                  <h3>The user has not started any discussion</h3>  
                                  @endif
                               @endif




                        


                        </div>










                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">


                        </div>
                        <!-- /.tab-pane -->
                        @if (auth()->id() == $user->id)
                        <div class="tab-pane" id="settings">


                            <form action="{{route('user.update', $user->id)}}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="name" class="form-control" value="{{$user->name}}" id="inputName" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" value="{{$user->email}}"  class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone"   class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{$user->phone}}" class="form-control" name="phone" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Education</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control"  name="education" placeholder="Describe your education background">{{$user->education}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                    <div class="col-sm-10">
                                        <input type="text " value="{{$user->skills}}" class="form-control" name="skills" placeholder="Skills separated by a comma">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">profession</label>
                                    <div class="col-sm-10">
                                        <input type="text " class="form-control" name="proffesion" value="{{$user->proffesion}}" placeholder="Your profession">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Country</label>
                                    <div class="col-sm-10">
                                        <input type="text " class="form-control" value="{{$user->country}}" name="country" placeholder="Your Country">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Your Bio</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control"  name="bio" placeholder="A short introduction about yourself eg.a Fullstack software engineer)">{{$user->bio}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Update details</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        @else
                           
                        @endif
                    
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
@endsection