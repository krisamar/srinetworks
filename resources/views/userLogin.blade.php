<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Login</title>
	<style>
    /* TODO 4: Use flexbox to center the card in the vertical and horizontal center. */
    .flex-container{
      height: 100vh;
      display:flex;
      justify-content: center;
      align-items: center;
    }
  </style>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="wrapper">
			<div class="wrapper-content">
				<div class="flex-container">
					<form action="/authenticate" method="post">
						@csrf
						<div class="col-sm-12">
							<div class="row">
								<div class="card" width="18rem">
									<div class="card-body">
										<h3 class="card-title">User Login</h3>
										<div class="card-text row mt-3">
											<label for="email" class="col-form-label col-sm-4">Email</label>
											<div class="col-sm-8">
												<input type="text" class="form-control input-sm" id="email" name="email">
												@if($errors->has('email'))
													<span class="form-text form-danger fwb">
														<i class="fas fa-info-circle"></i>{{$errors->first('email')}}
													</span>
												@endif
											</div>
										</div>
										<div class="card-text row mt-3">
											<label for="password" class="fol-form-label col-sm-4">Password</label>
											<div class="col-sm-8">
												<input type="password" id="password" class="input-sm form-control" name="password">
												@if($errors->has('password'))
													<span class="form-danger form-text fwb">
														<i class="fas fa-info-circle"></i>{{$errors->first('password')}}
													</span>
												@endif
											</div>
										</div>
										<div class="card-footer text-center fwb mt-4">
											<input type="hidden" name="role" value="1"> 
											<button class="btn btn-success" type="submit">Login</button>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<a href="/adminLogin">Admin Login</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>