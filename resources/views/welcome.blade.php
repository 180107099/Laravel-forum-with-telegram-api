@extends('layouts.app')

@section('content')
    

<div class="row">
    <div class="col-lg-8">
      <div class="row">

        @if (count($categories) > 0)
            @foreach ($categories as $category)
            <div class="col-lg-12 table-responsive">
              <!-- second section  -->
              <a href="{{route('category.overview', $category->id)}}">
                <h4 class="text-white bg-info mb-0 p-4 rounded-top">
                  {{$category->title}}
                </h4>
              </a>
              <table
                class="table table-striped table-responsive table-bordered"
              >
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Forum</th>
                    <th scope="col">Topics</th>
                    {{-- <th scope="col">Posts</th> --}}
                    {{-- <th scope="col">Latest Post</th> --}}
                  </tr>
                </thead>
                <tbody>

                  @if (count($category->forums) > 0)
                      @foreach (($category->forums) as $forum)
                      <tr>
                        <td>
                          <h3 class="h5">
                            <a href="{{route('forum.overview', $forum->id)}}" class="text-uppercase">{{$forum->title}}</a>
                          </h3>
                          <p class="mb-0">
                            {!!$forum->desc!!}
                          </p>
                        </td>
                        <td><div>{{$forum->discussions->count()}}</td>
                        
                        {{-- <td>
                          <h4 class="h6 font-weight-bold mb-0">
                            <a href="#">Post name</a>
                          </h4>
                          <div><a href="#">Author name</a></div>
                          <div>06/07/ 2021 20:04</div>
                        </td> --}}
                      </tr>
                      @endforeach
                  @else
                      <p>0 Forums found in this category</p>
                  @endif
                </tbody>
              </table>
            </div>
            @endforeach
        @else
            <h1>No Forum categories found</h1>
        @endif
        <!-- Category one -->
      </div>
    </div>
    <div class="col-lg-4">
      <aside>
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Members Online</h4>
            <ul class="list-unstyled mb-0">
             @if (count($users_online) > 0)
                 @foreach ($users_online as $user)
                 <li><a href="{{route('client.user.profile', $user->id)}}">{{$user->name}} <span class="badge badge-pill badge-success">online</span></a></li>
                 @endforeach
             @endif
            </ul>
          </div>
          <div class="card-footer">
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">All Members</h4>
            <ul class="list-unstyled mb-0">
             @if (count($few_users) > 0)
                 @foreach ($few_users as $user)
                 <li><a href="{{route('client.user.profile', $user->id)}}">{{$user->name}}</a></li>
                 @endforeach
             @endif
            <li><a href="{{route('client.users')}}" class="text-success">View All...</a></li>
            </ul>
          </div>
          <div class="card-footer">
           
          </div>
        </div>
     
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Members Statistics</h4>
            <dl class="row">
              <dt class="col-8 mb-0">Total Categories:</dt>
              <dd class="col-4 mb-0">{{$totalCategories}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-8 mb-0">Total Forums:</dt>
              <dd class="col-4 mb-0">{{$forumsCount}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-8 mb-0">Total Topics:</dt>
              <dd class="col-4 mb-0">{{$topicsCount}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-8 mb-0">Total members:</dt>
              <dd class="col-4 mb-0">{{$totalMembers}}</dd>
            </dl>
          </div>
          <div class="card-footer">
            <div>Newest Member</div>
            @if ($newest)
            <div><a href="#">{{$newest->name}}</a></div>
            @else
            <div><p>No users yet!</p></div>
            @endif
          </div>
        </div>
      </aside>
    </div>
  </div>
</div>

@endsection





























   {{-- @if (Route::has('login'))
   <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
       @auth
           <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
       @else
           <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

           @if (Route::has('register'))
               <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
           @endif
       @endauth
   </div>
@endif --}}