<?php include('tree.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		h1{
			text-align: center;
			text-transform: uppercase;
		}

	</style>
</head>
<body>
	<?php $id = 0; ?>
	<?php $s_id = person_info($id)['s_id']; ?>
	<h1>Persioin Name : <?php echo person_info($id)['name']; ?></h1>
	<div>
		<h2><?php echo(person_info($id)['gender'] == "m" ? "Wife" : "Husband") ;?></h2>
		<h3><?php //echo spous($id,"data")['name'] ?></h3>
		<h3><table><?php echo spous($id,"table") ?></table></h3>
	</div>
	<div>
		<h2>Siblings</h2>
		<h3><table><?php //echo sibling($id); ?></table></h3>
	</div>
	<div class="childrens">
		<h2>Childrens</h2>
		<h3><table><?php //echo children($id); ?></table></h3>




		<pre>
		<table>
			<thead>
				<th>Id</th>
				<th>Name</th>
				<th>Relation</th>
				<th>P_ID</th>
				<th>S_ID</th>
				<th>Gender</th>
			</thead>
			<tbody>
				<?php echo spous($id,"table"); ?>
				<?php //echo sibling($id); ?>
				<?php echo children($id,$id,0); ?>
			</tbody>
		</table>
		</pre>
	</div>

	

</body>
</html>



