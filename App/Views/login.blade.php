
<div class="row justify-content-md-center">
    <div class="col col-md-4 col-sm-12">
        <form method="post" hx-post="?page=login" hx-target="#container">
            <h2>Login</h2>
            <label class="mb-3 w-100">
                Email
                <input type="text" class="form-control 
                {{(isset($validationErrors) && $validationErrors->first('email')!==null)?' is-invalid ':''}}" 
                value="{{isset($validation)?$validation->getValidatedData()['email']:''}}"
                name="email" />
                @if((isset($validationErrors) && $validationErrors->first('email')!==null))
                <div class="invalid-feedback">
                    {{isset($validationErrors) && $validationErrors->first('email')?$validationErrors->first('email'):''}}
                </div>
                @endif
            </label>
            <label class="mb-3 w-100">
                Password
                <input type="password" class="form-control 
                {{(isset($validationErrors) && $validationErrors->first('password')!==null)?' is-invalid ':''}}" 
                value="{{isset($validation)?$validation->getValidatedData()['password']:''}}"
                name="password" />
                @if((isset($validationErrors) && $validationErrors->first('password')!==null))
                <div class="invalid-feedback">
                    {{isset($validationErrors) && $validationErrors->first('password')?$validationErrors->first('password'):''}}
                </div>
                @endif
            </label>
            @if (isset($loginFail))
            <div class="alert alert-danger" role="alert">
                Email or password is wrong
            </div>
            @endif 
            <input type="submit" value="Login" name="login" class="btn btn-primary w-100">
            <br><br><br><br>
            <button hx-target="#container" hx-get="?page=welcome" class="btn btn-secondary w-100"><< Back <<</button>
        </form>

    </div>
</div>
