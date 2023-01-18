<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#btn3").click(function(){
    $("#needrow").append($('#row').clone());
  });
});


</script>
</head>
<body>

<p>This is a paragraph.</p>
<p>This is another paragraph.</p>

<ol>
  <li>List item 1</li>
  <li>List item 2</li>
  <li>List item 3</li>
</ol>

<table border="1">
    <thead>
        <tr>
            <th>A</th>
            <th>B</th>
        </tr>
    </thead>
    <tbody id="needrow">
        <tr id="row">
            <td id='a'>Yoh Yoh</td>
            <td>Amigo</td>
        </tr>
    </tbody>
</table>

<button id="btn1">Append text</button>
<button id="btn2">Append list item</button>
<button id="btn3">New Row</button>

</body>
</html>
