<?php
$categories = $language_content['language'];
?>
<section>
	<div class="block gray less-top less-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="innertitle">
						<h2><?php echo $categories['lg_categories']; ?></h2>
						<span><?php echo $categories['lg_choose_the_suitable_category']; ?></span>
					</div>
				</div>
				<div class="col-lg-6">
					<ul class="breadcrumbs">
						<li><a href="<?php echo base_url();?>" title=""><?php echo $categories['lg_home']; ?></a></li>
						<li><a><?php echo $categories['lg_categories']; ?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="block remove-top">
		<div class="container">
			<div class="ml-filterbar s2">
				<?php 
				$pagination=explode('|',$this->ajax_pagination->create_links());
				?>
				<h3><i class="flaticon-eye"></i><?php echo $pagination[0];?> Results Found</h3>
			</div>
            <!-- Categories Starts -->						
            <div class="catsec">
				<div class="row" id="dataList">

					<?php
					if(!empty($category))
					{
						foreach ($category as $crows) {
					
							?>
					<div class="col-lg-4">
						<div class="category">
							<img src="<?php echo base_url().$crows['category_image'];?>" alt="" />
							<div class="cattitle">
								<h3><a href="#" title=""><i class="fa fa-circle" aria-hidden="true"></i> <?php echo ucfirst($crows['category_name']);?></a></h3>
							</div>
                            <div class="catcount">
                            	<i class="fa fa-clone" aria-hidden="true"></i> <?php echo $crows['category_count'];?> <i class="fa fa-dot-circle-o yellow" aria-hidden="true"></i>
                            </div>
						</div><!-- Category -->
					</div>
				<?php } }
				else { 
				
					echo '<div class="col-lg-12">
						<div class="category">
							No Categories Found
						</div><!-- Category -->
					</div>';
				 } 
				  
				 if(isset($pagination[1]) && !empty($pagination[1]))
				 {
				 	echo $pagination[1];
				 }
				  ?>

             
			
					
					
				</div>
			</div>
            <!-- Categories Ends -->	
		</div>
	</div>
</section>