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

jimport('joomla.filesystem.folder');

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "getid3" . DIRECTORY_SEPARATOR . "getid3" . DIRECTORY_SEPARATOR . "getid3.php");

class MusicFolder {

    // the music tag; see MusicTag class
    // i.e. represents the {music...}/some/path{/music} for this folder
    private $musicTag;
    private $overridePath;

    public function __construct(MusicTag $musicTag) {
        $this->musicTag = $musicTag;
    }

    public function setOverridePath($override) {
        $this->overridePath = $override;
    }

    public function getPathTrail() {
        return empty($this->overridePath) ? $this->musicTag->getPathTrail() : $this->overridePath;
    }

    public function getMusicItems($ascending, $count, $offset = 0) {
        $files = $this->getSortedFilteredFiles($ascending);
        $upper = min($offset + $count, count($files));
        return $this->getMusicItemsBetweenBoundaries($files, $offset, $upper);
    }

    public function isExists() {
        return JFolder::exists($this->getFileBasePath());
    }

    public function getUrlBasePath() {
        $siteUrl = JURI :: base(true);
        if (substr($siteUrl, -1) == "/") {
            $siteUrl = substr($siteUrl, 0, -1);
        }
        return $siteUrl . "/" . $this->getPathTrail();
    }

    public function getFileBasePath() {
        return JPATH_SITE . DIRECTORY_SEPARATOR . $this->getPathTrail();
    }

    private function getSortedFilteredFiles($ascending) {
        $files = $this->getFilteredFiles();
        $this->sortFileNames($files);
        if (!$ascending) {
            return array_reverse($files);
        }
        return $files;
    }

    private function sortFileNames(&$files) {
        switch ($this->musicTag->getConfiguration()->getSortBy()) {
            case Configuration::SORT_BY_FILEATIME:
                usort($files, array($this, "compareByFileTimeAccess"));
                break;
            case Configuration::SORT_BY_FILECTIME:
                usort($files, array($this, "compareByFileTimeCreated"));
                break;
            case Configuration::SORT_BY_FILEMTIME:
                usort($files, array($this, "compareByFileTimeModified"));
                break;
            case Configuration::SORT_BY_FILENAME:
            default:
                usort($files, array($this, "compareByFileName"));
        }
    }

    function compareByFileTimeAccess($a, $b) {
        $basePath = $this->getFileBasePath();
        $al = fileatime($basePath . DIRECTORY_SEPARATOR . $a);
        $bl = fileatime($basePath . DIRECTORY_SEPARATOR . $b);
        return $al - $bl;
    }

    function compareByFileTimeCreated($a, $b) {
        $basePath = $this->getFileBasePath();
        $al = filectime($basePath . DIRECTORY_SEPARATOR . $a);
        $bl = filectime($basePath . DIRECTORY_SEPARATOR . $b);
        return $al - $bl;
    }

    function compareByFileTimeModified($a, $b) {
        $basePath = $this->getFileBasePath();
        $al = filemtime($basePath . DIRECTORY_SEPARATOR . $a);
        $bl = filemtime($basePath . DIRECTORY_SEPARATOR . $b);
        return $al - $bl;
    }

    function compareByFileName($a, $b) {
        return strcmp($a, $b);
    }

    private function getFilteredFiles() {
        $results = array();
        $files = JFolder::files($this->getFileBasePath());
        $fileFilter = $this->musicTag->getConfiguration()->getFileFilter();
        $pattern = "/^" . $fileFilter . "$/i";
        foreach ($files as $file) {
            if (preg_match($pattern, basename($file))) {
                $results[] = $file;
            }
        }
        return $results;
    }

    private function getMusicItemsBetweenBoundaries($files, $lower, $upper) {
        $musicItems = array();
        for ($i = $lower; $i < $upper; $i++) {
            $file = $files[$i];
            $musicItems[] = $this->getMusicItemForFilePathName($file);
        }
        return $musicItems;
    }

    private function getMusicItemForFilePathName($file) {
        $getID3 = new getID3;
        $getID3->encoding = "UTF-8";
        $getID3->encoding_id3v1 = $this->musicTag->getConfiguration()->getId3v1Encoding();
        $filePathName = $this->getFileBasePath() . DIRECTORY_SEPARATOR . $file;
        $ThisFileInfo = $getID3->analyze($filePathName);
        getid3_lib::CopyTagsToComments($ThisFileInfo);
        require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "MusicItem.php");
        return new MusicItem($this, $file, $ThisFileInfo);
    }

}
