  @extends('layout.layout')

  @section('content')
      <section class="vh-100">
        <div class="container py-5 h-100">
    <div class="wrapper">
        <h1>Sign Up</h1>
        <form action="{{ route('register.post') }}" method="post">
          @csrf
            <!-- <input type="text" placeholder="Username" name="username"> -->
            <input type="text" placeholder="Name"  name="name">
            <input type="email" placeholder="Email"  name="email">
            <input type="text" placeholder="Username" name="username">
            <input type="password" placeholder="Password" name="password">
            <button type="submit">Sign up</button>

         </form>
         <div class="terms">
            <input type="checkbox" id="checkbox">
            <label for="checkbox">I agree to these <a href="#">Terms & Conditions</a></label>
    </div>
    <div class="member">
        Already a member? <a href="/">
            Login Here
        </a>
    </div>
</div>
@endsection