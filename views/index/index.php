<?php $servers = $this->get('server'); ?>

<link href="<?=$this->getModuleUrl('static/css/servers.css') ?>" rel="stylesheet">

<div id="server">
<?php if ($servers): ?>
    <?php foreach ($servers as $server): ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'show', 'id' => $server->getId()]) ?>">
                <?php if ($server->getOnline()): ?>
                <?=$server->getHostname() ?>
                <?php else: ?>
                <?=$this->getTrans('offline') ?>
                <?php endif; ?>
            </a>
        </div>
        <div class="panel-body">
            <div  id="show-info">
                <div class="col-md-12 col-lg-4">
                    <a href="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'show', 'id' => $server->getId()]) ?>">
                        <?php if ($server->getOnline()): ?>
                        <?php
                            /* Essential variables */
                            $margin_bottom = 350;
                            $margin_left_right = 120;
                            $quote_size = 75;
                            $author_size = intval($quote_size / 1.5);
                            $padding = 50;
                            $quote = $server->getHostname();
                            $author = $this->getTrans('playing')." ".$server->getGame_id(). " " . $server->getGametype();
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
                    </a>
                </div>
                <div class="col-md-12 col-lg-8">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <?=$this->getTrans('server') ?>
                            <span class="badge">
                                <a href="<?=$this->getUrl(['module' => 'minecraftserver', 'controller' => 'index', 'action' => 'show', 'id' => $server->getId()]) ?>">
                                    <?=$server->getHostname() ?>
                                </a>
                            </span>
                        </li>
                        <li class="list-group-item">
                            <?=$this->getTrans('serverAdress') ?>
                            <span class="badge"><?= $server->getMinecraftserver().":".$server->getHostport()?></span>
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <?=$this->getTrans('noServer') ?>
<?php endif; ?>
</div>
