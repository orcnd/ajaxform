
<div class="row justify-content-md-center">
    <div class="col col-md-4 col-sm-12">
        <form method="post" id="form" hx-post="?page=register" hx-encoding="multipart/form-data" hx-target="#container"
         _='on htmx:xhr:progress(loaded, total) set #progress.value to (loaded/total)*100'
        >
            <h2>Register </h2>
            <label class="mb-3 w-100">
                Name
                <input type="text" name="name" class="form-control 
                {{(isset($validationErrors) && $validationErrors->first('name')!==null)?' is-invalid ':''}}" 
                value="{{isset($validation)?$validation->getValidatedData()['name']:''}}"
                />
                @if((isset($validationErrors) && $validationErrors->first('name')!==null))
                <div class="invalid-feedback">
                    {{isset($validationErrors) && $validationErrors->first('name')?$validationErrors->first('name'):''}}
                </div>
                @endif
            </label>
            <label class="mb-3 w-100 w-100">
                Email
                <input type="text" class="form-control w-100
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
                Avatar
                <input class="form-control
                {{(isset($validationErrors) && $validationErrors->first('avatar')!==null)?' is-invalid ':''}}" 
                 type="file" name="avatar" />
                <progress id='progress' value='0' max='100'></progress>
                @if((isset($validationErrors) && $validationErrors->first('avatar')!==null))
                <div class="invalid-feedback">
                    {{isset($validationErrors) && $validationErrors->first('avatar')?$validationErrors->first('avatar'):''}}
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
            <input type="submit" value="Register" name="register" class="btn btn-primary ">
            <br><br><br><br>
            <button hx-target="#container" hx-get="?page=welcome" class="btn btn-secondary"><< Back <<</button>
        </form>

    </div>
</div>
