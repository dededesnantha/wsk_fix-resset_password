<html>
	<head>
		<title>Email Booking</title>
	<style type="text/css" media="screen">
			html{ 
			background: #efefef }
		</style>
	</head>
	
	<body style=" color: #000;background: #fff;margin: 1rem auto;max-width:700px;overflow-x: hidden;font-family: sans-serif;">
		<div style="width: 100%;padding: 30px;display: table-cell;margin-top: 40px">

			<h1 style="color:#696969;text-align: center;padding-bottom: 25px;border-bottom: 3px solid;border-bottom-color: #27c24c;padding-top: 20px;">{{$site->judul}}</h1>
			
			<h3>Booking Information ,</h3>
			<br>
			<br>
			Detail booking form website {{$site->judul}}:
			<br>
			<br>

			<table>					
				<tbody>
					<tr>
						<td>Name</td>
						<td>:</td>
						<td>{{$request['gender']}} {{$request['name']}} {{$request['last_name']}}</td>
					</tr>
					<tr>
						<td>Address / Hotel Address</td>
						<td>:</td>
						<td>{{$request['address']}}</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td><a href="mailto:{{$request['email']}}">{{$request['email']}}</a></td>
					</tr>
					<tr>
						<td>Hotel</td>
						<td>:</td>
						<td>{{$request['hotel']}}</td>
					</tr>
					<tr>
						<td>Phone / Hotel Number</td>
						<td>:</td>
						<td>{{$request['phone']}}</td>
					</tr>
					<tr>
						<td>Activities Date</td>
						<td>:</td>
						<td>{{$request['date']}}</td>
					</tr>
					<tr>
						<td>Child</td>
						<td>:</td>
						<td>{{$request['child']}}</td>
					</tr>
					<tr>
						<td>Adult</td>
						<td>:</td>
						<td>{{$request['adult']}}</td>
					</tr>
					<tr>
						<td><b>Tour Activities</b></td>
						<td>:</td>
						<td>
							<br>
							<b>Select Tour</b><br>
							@foreach($request['tour'] as $key)
								{{$key}}<br>
							@endforeach
							<br>
							<b>Custom Tour</b><br>
							@foreach($request['custom_tour'] as $key)
								{{$key}}<br>
							@endforeach
							<br>

						</td>
					</tr>
					<tr>
						<td>Message</td>
						<td>:</td>
						<td>{{$request['message']}}</td>
					</tr>
				</tbody>
			</table>	
			
			<br>
			<br>
			<p>Best Regards,</p>
			<br>
			<br>
			<div style="color:grey;text-align: center;padding: 10px;background-color: #EDECEC">
				<strong style="color:#696969;">{{$site->judul}}</strong><br>
				<small>{{$site->alamat}}</small><br>
				@foreach($kontak as $key)
					<small>{{$key->judul}}:{{$key->kontak}}</small><br>
				@endforeach
				<small><a href="{{url('')}}" title="{{$site->judul}}">{{url('')}}</a></small><br>
				<small>Powered by <a href="https://www.tayatha.com/" title="tayatha" target="_blank" class="w3-hover-opacity">tayatha</a></small>
			</div>
		</div>
	</body>
</html>