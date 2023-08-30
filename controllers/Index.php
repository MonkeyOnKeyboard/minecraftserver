<?php

namespace Modules\Minecraftserver\Controllers;

use Modules\Minecraftserver\Mappers\Server as ServerMapper;
use Modules\Minecraftserver\Models\Server as ServerModel;

class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {
        $mapper = new ServerMapper();
        $servers = $mapper->getMincraftServer(($this->getConfig()->get('minecraftserver_showOffline') ? [] : ['online' => 1]));

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuServer'), ['action' => 'index']);

        if ($this->getConfig()->get('minecraftserver_requestEveryPageCall') == 1) {
            $servers = $this->updateServer();
        }

        $this->getView()->set('server', $servers);
    }

    public function showAction()
    {
        $mapper = new ServerMapper();

        $servers = $mapper->readById($this->getRequest()->getParam('id'));
        if (!$servers) {
            $this->redirect()
                    ->to(['action' => 'index']);
        }

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuServer'), ['action' => 'index'])
            ->add($servers->getMinecraftserver(), ['id' => $servers->getId()]);

        if ($this->getConfig()->get('minecraftserver_requestEveryPageCall') == 1) {
            $this->updateServer($servers);
        }

        $this->getView()->set('server', $servers);
    }

    public function updateAction()
    {
        $this->updateServer();
    }

    public function imgAction()
    {
        header("Content-Type: image/png");
        $this->getLayout()->setFile('modules/hangman/layouts/iframe');

        $mapper = new ServerMapper();

        $server = $mapper->readById($this->getRequest()->getParam('id') ?? 0);

        if ($server) {
            /* Essential variables */
            $margin_bottom = 350;
            $margin_left_right = 120;
            $quote_size = 75;
            $author_size = intval($quote_size / 1.5);
            $padding = 50;

            $author = $this->getTranslator()->trans('playing') . " " . $server->getGameId() . " " . $server->getGametype();
            $im = imagecreate(1920, 1080);
            $quote_font =  APPLICATION_PATH . '/modules/minecraftserver/static/fonts/freedom.ttf';
            $author_font = APPLICATION_PATH . '/modules/minecraftserver/static/fonts/newboba.ttf';
            $white = imagecolorallocatealpha($im, 255, 255, 255, 20);
            $black = imagecolorallocate($im, 0, 0, 0);

            /* Author */
            $author_text_sizes = imagettfbbox($author_size, 0, $author_font, $author);
            $author_width = $author_text_sizes[4];
            $author_height = $author_text_sizes[1];
            $author_position_bottom = 1080 - $author_height - $margin_bottom;

            /* Copyright */
            $author_text_sizes = imagettfbbox($author_size / 1.5, 0, $author_font, $server->getMinecraftserver() . ":" . $server->getHostport());
            $author_width = $author_text_sizes[4];
            $author_height = $author_text_sizes[1];
            imagettftext($im, $author_size / 1.5, 0, 1920 - $author_width - 120 + $padding, 1080 - $author_height - $padding / 2, $black, $author_font, $server->getMinecraftserver() . ":" . $server->getHostport());

            /* Setting of word wrapping */
            $words = explode(' ', $server->getHostname());
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
            $text_size = imagettfbbox($quote_size, 0, $quote_font, $quote);

            $text_position_bottom = $author_position_bottom - $text_size[1] - 1.5 * $padding;

            // Text background is created and integrated
            imagefilledrectangle(
                $im,
                $margin_left_right - $padding, // links
                $text_position_bottom - $quote_size - $padding, // Oben
                1920 - 120 + $padding, // Rechts
                1080 - $margin_bottom + $padding, // Unten
                $white
            );

            // The quote is written into the picture

            imagettftext($im, $quote_size, 0, $margin_left_right, $text_position_bottom, $black, $quote_font, $quote);
            imagettftext($im, $author_size, 0, $margin_left_right, $author_position_bottom, $black, $author_font, $author);

            // Using imagepng () yields better text quality than imagejpeg()
            imagepng($im);
            imagedestroy($im);
        }
    }

    /**
     * @param ServerModel|null $server
     * @return ServerModel[]|null
     */
    public function updateServer(?ServerModel $server = null): ?array
    {
        $mapper = new ServerMapper();
        return $mapper->updateDataServer($server);
    }
}
