<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body>
    <!-- Login 8 - Bootstrap Brain Component -->
<section class="bg-light p-3 p-md-4 p-xl-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xxl-11">
        <div class="card border-light-subtle shadow-sm">
          <div class="row g-0">
            <div class="col-12 col-md-6">
              <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="https://bootstrapbrain.com/demo/components/logins/login-8/assets/img/logo-img-1.webp" alt="Welcome back you've been missed!">
            </div>
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
              <div class="col-12 col-lg-11 col-xl-10">
                <div class="card-body p-3 p-md-4 p-xl-5">
                  <div class="row">
                    <div class="col-12">
                      <div class="mb-5">
                       
                        <h4 class="text-center">Register Now</h4>
                      </div>
                    </div>
                  </div>
                  
                  <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="row gy-3 overflow-hidden">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="name" id="name" placeholder="name" >
                                    <label for="name" class="form-label">name</label>
                                    


                                    @if(Session::has('succes'))
                                    <div class="alert alert-success">{{Session::get('success')}}</div>
                                    @endif

                                    @if(Session::has('fail'))
                                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                                    @endif
                              
                                    <!-- @error("name")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror -->
                                </div>
                            </div>
                      </div>
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" >
                          <label for="email" class="form-label">Email</label>
                          @error("email")
                          <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                     <div class="col-12">
   <div class="form-floating mb-3">
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    <label for="password" class="form-label">Password</label>
    @error("password")
    <span class="text-danger">{{ $message }}</span>
    @enderror 
   </div>
  
   <div class="form-floating mb-3">
    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    @error("password_confirmation")
    <span class="text-danger">{{ $message }}</span>
    @enderror
   </div>
   </div>

                      <div class="col-12">
                        <div class="d-grid">
                          <button class="btn btn-dark btn-lg" type="submit">Sign UP</button>
                          <br>
                          <a href="http://127.0.0.1:8000/login" class="link-secondary text-decoration-none">DO you already have Account ? Login Now</a>
                        </div>
                      </div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-12">
                      <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>