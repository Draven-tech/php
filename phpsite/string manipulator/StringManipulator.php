<?php
class StringHandler {
    private $content = "";

    public function addText($text) {
        $this->content .= $text;
        return $this;
    }

    public function prependText($text) {
        $this->content = $text . $this->content;
        return $this;
    }

    public function convertToUpper() {
        $this->content = strtoupper($this->content);
        return $this;
    }

    public function convertToLower() {
        $this->content = strtolower($this->content);
        return $this;
    }

    public function getFinalText() {
        return $this->content;
    }
}

$handler = new StringHandler();
echo $handler->addText("world")->prependText("Hello ")->convertToUpper()->getFinalText();
?>
