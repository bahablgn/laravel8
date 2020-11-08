@extends('people.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>People</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('people.create') }}"> Create New Person</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {{-- <pre>
        {{var_dump($qq)}}
    </pre> --}}
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Lastname</th>
            <th>Title</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Company</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($people as $person)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $person->name }}</td>
            <td>{{ $person->lastname }}</td>
            <td>{{ $person->title }}</td>
            <td>{{ $person->email }}</td>
            <td>{{ $person->phone }}</td>
            <td>{{ $company->find($person->company_id)->name }}</td>
            <td>
                <form action="{{ route('people.destroy',$person->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('people.show',$person->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('people.edit',$person->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $people->links() !!}
      
@endsection