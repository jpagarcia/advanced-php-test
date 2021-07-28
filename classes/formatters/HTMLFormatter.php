<?php

require_once('classes/formatters/TableFormatter.php');

class HTMLFormatter extends TableFormatter
{
    public function output()
    {
        if (!$this->data->count()) {
            return $this->htmlTemplate('Sorry, no matching data was found');
        }

        return $this->htmlTemplate('<table>' . $this->getHeaders($this->data) . $this->getRows($this->data) . '</table>');
    }

    protected function getHeaders($data) {

        $headers = $this->formatHeaders($data);

        return '<tr><th>' . $headers->join('</th><th>') . '</th></tr>';
    }

    protected function getRows($data) {

        $rows = [];

        foreach ($data as $dataRow) {

            $row = '<tr>';

            foreach ($dataRow as $key => $value) {
                $row .= "<td>$value</td>";
            }

            $row .= '</tr>';

            $rows[] = $row;
        }

        return implode('', $rows);
    }

    // wrap html in a standard template
    private function htmlTemplate($html)
    {
        return "
<html>
<head>
<style type='text/css'>
    body {
        font: 16px Roboto, Arial, Helvetica, Sans-serif;
    }
    td, th {
        padding: 4px 8px;
    }
    th {
        background: #eee;
        font-weight: 500;
    }
    tr:nth-child(odd) {
        background: #f4f4f4;
    }
</style>
</head>
<body>$html</body>
</html>";
    }
}
