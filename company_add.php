<?php
include "header.php";


if (isset($_COOKIE['edit_id'])) {
	$mode = 'edit';
	$editId = $_COOKIE['edit_id'];
	$stmt = $obj->con1->prepare("select * from company where id=?");
	$stmt->bind_param('i', $editId);
	$stmt->execute();
	$data = $stmt->get_result()->fetch_assoc();
	$stmt->close();
}

if (isset($_COOKIE['view_id'])) {
	$mode = 'view';
	$viewId = $_COOKIE['view_id'];
	$stmt = $obj->con1->prepare("select * from company where id=?");
	$stmt->bind_param('i', $viewId);
	$stmt->execute();
	$data = $stmt->get_result()->fetch_assoc();
	$stmt->close();
}


// insert data
if(isset($_REQUEST['btnsubmit']))
{
	$company_name = $_REQUEST['company_name'];
    $address = $_REQUEST['address'];
    $crossing = $_REQUEST['crossing'];
    $country_name = $_REQUEST['country_name'];
    $state = $_REQUEST['state_name'];
	$city = $_REQUEST['city_name'];
    $postal_code = $_REQUEST['postal_code'];
    $phone = $_REQUEST['phone'];
    $email = $_REQUEST['email'];
    $website = $_REQUEST['website'];
    $tax1 = $_REQUEST['tax_num1'];
    $tax2 = $_REQUEST['tax_num2'];
	try
	{
		//echo "INSERT INTO `city`(`city_name`,`state_id`,`status`) VALUES ('".$city_name."', '".$state_name."', '".$status."')";


		echo "INSERT into company(`id`, `company_name`, `address`, `crossing`, `country_name`, `state_name`, `city_name`, `postal_code`, `phone`, `email`, `website`, `tax_num1`, `tax_num2`) VALUES ('".$company_name."','".$address."','".$crossing."','".$country_name."','".$state."','".$city."','".$postal_code."','".$phone."','".$email."','".$website."','".$tax1."','".$tax2."','".$company_name."')";

		$stmt = $obj->con1->prepare("INSERT INTO `company`(`company_name`,`address`,`crossing`,`country_name`,`state_name`,`city_name`,`postal_code`,`phone`,`email`,`website`,`tax_num1`,`tax_num2`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param("ssssssssssss",$company_name,$address,$crossing,$country_name,$state,$city,$postal_code,$phone,$email,$website,$tax1,$tax2);
		$Resp=$stmt->execute();
		if(!$Resp)
		{
			throw new Exception("Problem in adding! ". strtok($obj->con1-> error,  '('));
		}
		$stmt->close();
	} 
	catch(\Exception  $e) {
		setcookie("sql_error", urlencode($e->getMessage()),time()+3600,"/");
	}


	if($Resp)
	{
		setcookie("msg", "data",time()+3600,"/");
		header("location:company.php");
	}
	else
	{
		setcookie("msg", "fail",time()+3600,"/");
		header("location:company.php");
	}
}

if(isset($_REQUEST['btnupdate']))
{
	$company_name = $_REQUEST['company_name'];
    $address = $_REQUEST['address'];
    $crossing = $_REQUEST['crossing'];
    $country_name = $_REQUEST['country_name'];
    $state = $_REQUEST['state_name'];
	$city = $_REQUEST['city_name'];
    $postal_code = $_REQUEST['postal_code'];
    $phone = $_REQUEST['phone'];
    $email = $_REQUEST['email'];
    $website = $_REQUEST['website'];
    $tax1 = $_REQUEST['tax_num1'];
    $tax2 = $_REQUEST['tax_num2'];
	$e_id=$_COOKIE['edit_id'];
	
	try
	{
         echo"UPDATE units SET `unit_name`=$unit_name, `abbriviation`=$abbriviation, `status`=$status where id=$e_id";
		$stmt = $obj->con1->prepare("UPDATE company SET `company_name`=?, `state_name`=?, `city_name`=?, `phone`=?, `email`=?, `website`=? where id=?");
		$stmt->bind_param("ssssssi",$company_name,$state,$city,$phone,$email,$website,$e_id);
		$Resp=$stmt->execute();
		if(!$Resp)
		{
			throw new Exception("Problem in updating! ". strtok($obj->con1-> error,  '('));
		}
		$stmt->close();
	} 
	catch(\Exception  $e) {
		setcookie("sql_error", urlencode($e->getMessage()),time()+3600,"/");
	}


	if($Resp)
	{
		setcookie("msg", "update",time()+3600,"/");
		header("location:company.php");
	}
	else
	{
		setcookie("msg", "fail",time()+3600,"/");
		 header("location:company.php");
	}
}
?>
<div class="row" id="p1">
	<div class="col-xl">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="mb-0"> <?php echo (isset($mode)) ? (($mode == 'view') ? 'View' : 'Edit') : 'Add' ?> Company</h5>

			</div>
			<div class="card-body">
				<form method="post" >

					<div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Company Name</label>
							<input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo (isset($mode)) ? $data['company_name'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">address</label>
							<input type="text" class="form-control" name="address" id="address" value="<?php echo (isset($mode)) ? $data['address'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Crossing</label>
							<input type="text" class="form-control" name="crossing" id="crossing" value="<?php echo (isset($mode)) ? $data['crossing'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Country Name</label>
							<input type="text" class="form-control" name="country_name" id="country_name" value="<?php echo (isset($mode)) ? $data['country_name'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">State</label>
							<input type="text" class="form-control" name="state_name" id="state_name"  value="<?php echo (isset($mode)) ? $data['state_name'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>
					</div>

                    <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">City</label>
							<input type="text" class="form-control" name="city_name" id="city_name" value="<?php echo (isset($mode)) ? $data['city_name'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Postal Code</label>
							<input type="text" class="form-control" name="postal_code" id="postal_code" value="<?php echo (isset($mode)) ? $data['postal_code'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Contact</label>
							<input type="text" class="form-control" name="phone" id="phone" value="<?php echo (isset($mode)) ? $data['phone'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Email</label>
							<input type="text" class="form-control" name="email" id="email" value="<?php echo (isset($mode)) ? $data['email'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Website</label>
							<input type="text" class="form-control" name="website" id="website" value="<?php echo (isset($mode)) ? $data['website'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Tax No. 1</label>
							<input type="text" class="form-control" name="tax_num1" id="tax_num1" value="<?php echo (isset($mode)) ? $data['tax_num1'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>

                        <div class="row g-2">
						<div class="col mb-3">
							<label class="form-label" for="basic-default-fullname">Tax No. 2</label>
							<input type="text" class="form-control" name="tax_num2" id="tax_num2" value="<?php echo (isset($mode)) ? $data['tax_num2'] : '' ?>"
                            <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?> required />
						</div>


					
					<button type="submit"  name="<?php echo isset($mode) && $mode == 'edit' ? 'btnupdate' : 'btnsubmit' ?>" id="save"
                        class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>">
                        <?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                    </button>
                    <button type="button" class="btn btn-danger"
                        onclick="<?php echo (isset($mode)) ? 'javascript:go_back()' : 'window.location.reload()' ?>">
                     Close</button>

			</form>
		</div>
	</div>
</div>

</div>
<script>
	function go_back() {
    eraseCookie("edit_id");
    eraseCookie("view_id");
		window.location = "company.php";
	}
</script>
<?php
include "footer.php";
?>