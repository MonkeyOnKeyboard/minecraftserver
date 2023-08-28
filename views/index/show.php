<?php
$server = $this->get('server');
?>

<link href="<?=$this->getModuleUrl('static/css/servers.css') ?>" rel="stylesheet">

<div id="server">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?=$server->getHostname() ?>
        </div>
        <div class="panel-body">
            <div class="col-md-12 col-lg-4">
                <?php if ($server->getOnline()): ?>
                <?php
                            /* Essential variables */
                            $margin_bottom = 350;
                            $margin_left_right = 120;
                            $quote_size = 75;
                            $author_size = intval($quote_size / 1.5);
                            $padding = 50;
                            $quote = $server->getHostname();
                            $author = $this->getTrans('playing')." ".$server->getGame_id();
                            $im = imagecreate(1920,1080);
                            $quote_font =  dirname(__DIR__, 2).'/static/fonts/freedom.ttf';
                            $author_font = dirname(__DIR__, 2).'/static/fonts/newboba.ttf';
                            $white = imagecolorallocatealpha($im, 255, 255, 255,20);
                            $black = imagecolorallocate($im, 0, 0, 0);
                            
                            
                            
                            
                            
                            /* Author */
                            $author_text_sizes = imagettfbbox( $author_size,0 , $author_font, $author );
                            $author_width = $author_text_sizes[4];
                            $author_height = $author_text_sizes[1];
                            $author_position_bottom = 1080-$author_height-$margin_bottom;
                            
                            
                            
                            
                            
                            /* Copyright */
                            $author_text_sizes = imagettfbbox( $author_size/1.5 ,0 , $author_font, $server->getMinecraftserver().":".$server->getHostport() );
                            $author_width = $author_text_sizes[4];
                            $author_height = $author_text_sizes[1];
                            imagettftext($im, $author_size/1.5 , 0, 1920-$author_width-120+$padding, 1080-$author_height-$padding/2, $black, $author_font, $server->getMinecraftserver().":".$server->getHostport());
                            
                            
                            
                            
                            
                            
                            
                            /* Setting of word wrapping */
                            $words = explode(' ', $quote);
                            $quote = '';
                            $currentLine = '';
                            foreach ($words as $position => $word) {
                                if ($position === 0) {
                                    $currentLine = $word;
                                } else {
                                    $textDimensions = imagettfbbox(
                                        $quote_size,
                                        0,
                                        $quote_font,
                                        $currentLine . ' ' . $word
                                    );
                                    $textLeft = min($textDimensions[0], $textDimensions[6]);
                                    $textRight = max($textDimensions[2], $textDimensions[4]);
                                    $textWidth = $textRight - $textLeft;
                                    if ($textWidth > 1680) {
                                        $quote .= $currentLine;
                                        $quote .= PHP_EOL;
                                        $currentLine = $word;
                                    } else {
                                        $currentLine .= ' ';
                                        $currentLine .= $word;
                                    }
                                }
                            }
                            $quote .= $currentLine;
                            $text_size = imagettfbbox( $quote_size, 0, $quote_font, $quote );
                            
                            $text_position_bottom = $author_position_bottom-$text_size[1]-1.5*$padding;
                            
                            
                            
                            // Text background is created and integrated
                            imagefilledrectangle(
                                $im,
                                $margin_left_right-$padding, // links
                                $text_position_bottom-$quote_size-$padding, // Oben
                                1920 - 120 + $padding, // Rechts
                                1080 - $margin_bottom + $padding, // Unten
                                $white
                            );
                            
                            // The quote is written into the picture
                           
                            imagettftext($im, $quote_size, 0, $margin_left_right, $text_position_bottom, $black, $quote_font, $quote);
                            imagettftext($im, $author_size, 0, $margin_left_right, $author_position_bottom, $black, $author_font, $author);
                            
                            // Using imagepng () yields better text quality than imagejpeg()
                            ob_start();
                            imagejpeg($im, NULL, 100);
                            imagedestroy($im);
                            $i = ob_get_clean();

                            echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."' title='".$server->getHostname()." ".$this->getTrans('playing')." ".$server->getGame_id()."'>"; //saviour line!
                        ?>
                <?php else: ?>
                <span class="badge"><?=$this->getTrans('offline') ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-12 col-lg-8">
                <ul class="list-group">
                    <li class="list-group-item">
                        <?=$this->getTrans('server') ?>
                        <span class="badge">
                            <?= $server->getMinecraftserver().":".$server->getHostport()?>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <?=$this->getTrans('game') ?>
                        <span class="badge"><?=$server->getGame_id() ?> - <?=$server->getGametype() ?></span>
                    </li>
                    <li class="list-group-item">
                        <?=$this->getTrans('players') ?>
                        	<?php if ($server->getOnline() == 1): ?>
            					<span class="badge"><?=number_format($server->getNumplayers(), 0, '','.') . " " . $this->getTrans('of') . " " . number_format($server->getMaxplayers(), 0, '','.') ?></span>
            				<?php else: ?>
            					<span class="badge"> / </span>
            				<?php endif; ?>
                    </li>
                    <li class="list-group-item">
                        <?=$this->getTrans('onlineIs') ?>
                        <?php if ($server->getOnline()): ?>
                        <span class="badge"><?=$this->getTrans('online') ?></span>
                        <?php else: ?>
                        <span class="badge"><?=$this->getTrans('offline') ?></span>
                        <?php endif; ?>
                    </li>
                    <li class="list-group-item">
                    	<?=$this->getTrans('plugins') ?>
                    	<?php 
                    	$pluginData = unserialize($server->getPlugins());
                    	
                    	   if (!empty($pluginData)){
                    	       
                    	       echo "<span class=\"badge\">" . htmlspecialchars( $pluginData ). "</span>";

                    	   } else {
                    	       echo "<span class=\"badge\">".$this->getTrans('noPlugins')."</span>";
                    	   }
                    	   
                    	?>
                        
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-footer clearfix">
			<div class="pull-left">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">
                	<?=$this->getTrans('showPlayers') ?>
               </button>
               <div class="col">
               <div class="collapse multi-collapse" id="multiCollapseExample1">
                  <div class="card card-body">
                  	
                      	<table class="table table-bordered table-striped">
                          	<thead>
                          		<tr>
                          			<th><?=$this->getTrans('Players')?></th>
                          		</tr>
                          	</thead>
                          	<tbody>
					<?php $Players = unserialize($server->getPlayers());?>
                          	<?php if (!$Players): ?>
                          		<tr>
        							<td><?=$this->getTrans('noOnlineplayers')?></td>
        						</tr>
        						<?php else: ?>
        						<?php foreach( $Players as $Player ): ?>
        						<tr>
        							<td><?php echo htmlspecialchars( $Player ); ?></td>
        						</tr>
        						<?php endforeach; ?>
        						<?php endif; ?>
        					</tbody>
    					</table>
					</div>
                </div>
              </div>
            </div>
            <div class="pull-right">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">
                	 <?=$this->getTrans('showServer') ?>
                 </button>
                <div class="col">
                	<div class="collapse multi-collapse" id="multiCollapseExample2">
                  	<div class="card card-body">
                    	<div class="row">
            				<table class="table table-bordered table-striped">
            					<?php 
            					$Info = unserialize($server->getServerpinginfo());
            					?>
            					<?php if(!empty($Info)): ?>
                                    <?php foreach( $Info as $InfoKey => $InfoValue ): ?>
                						<tr>
                							<td><?php echo htmlspecialchars( $InfoKey ); ?></td>
                							<td><?php
                                            	if( $InfoKey === 'favicon' )
                                            	{
                                            		echo '<img width="64" height="64" src="' . Str_Replace( "\n", "", $InfoValue ) . '">';
                                            	}else if( Is_Array( $InfoValue ) )
                                            	{
                                            		
                                            	    echo "<pre>";
                                            		print_r( $InfoValue );
                                            		echo "</pre>";
                                            		                                    	    
                                            	    
                                            	}
                                            	else
                                            	{
                                            		echo htmlspecialchars( $InfoValue );
                                            	}
                                                ?>
                                           </td>
                                    	</tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                						<tr>
                							<td colspan="2" align="center"><?=$this->getTrans('noServerPingInfo') ?></td>
                						</tr>
                                    <?php endif; ?>
            				</table>
            		</div>	
                  </div>
                </div>
              </div>
            </div>
  
        </div>
    </div>
</div>


