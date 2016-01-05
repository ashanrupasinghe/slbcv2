<?php

/**
 * This file is part of mp3 Browser.
 *
 * This is free software: you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation, either version 2 of the
 * License, or (at your option) any later version.
 *
 * You should have received a copy of the GNU General Public License (V2) along with this. If not,
 * see <http://www.gnu.org/licenses/>.
 *
 * Previous copyright likely held by others such as Jon Hollis, Luke Collymore, as associated with
 * dotcomdevelopment.com.
 * Copyright 2012-'13 Totaal Software (www.totaalsoftware.com).
 */
defined("_JEXEC") or die("Restricted access");

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "HtmlColumn.php");

class HtmlNameColumn extends HtmlColumn {

    public function __construct($colSpan = 1) {
        parent::__construct($colSpan);
    }

    protected function getHeaderText() {
        return JText::_("PLG_MP3BROWSER_HEADER_NAME");
    }

    protected function getCellText($data, $isAlternate) {
        $html = $this->addItemAnchor($data);
        if ($data->getTitle()) {
            $title = $this->wrapAnchor($data, $data->getTitle());
            $html .= "<strong>" . $title . "</strong>";
        }
        if ($data->getArtist()) {
            $artist = $this->wrapAnchor($data, $data->getArtist());
            $html .= "<br/>" . $artist;
        }
        return $html;
    }

    private function addItemAnchor(MusicItem $data) {
        return "<a name=\"" . $data->getCdataName() . "\"></a>";
    }

    private function wrapAnchor(MusicItem $data, $textToWrap) {
        $url = $data->getUrl();
        if ($url) {
            return "<a href=\"" . $url . "\" target=\"_blank\">" . $textToWrap . "</a>";
        }
        return $textToWrap;
    }

}