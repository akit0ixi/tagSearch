<html>
<head>
<script>
document.addEventListener('click',function(e){
  var t=e.target;
  if(t.nodeName=="A"){
    doCopy(t.firstChild.nodeValue);
  }
});
function doCopy(txt){
  var ta = document.createElement("textarea");
  document.getElementsByTagName("body")[0].appendChild(ta);
  ta.value=txt;
  ta.select();
  var ret = document.execCommand('copy');
  ta.parentNode.removeChild(ta);
}
</script>
</head>
<body>
<input type="button" value="copy hoge" onclick="doCopy('hoge')">
<input type="button" value="copy fuga" onclick="doCopy('fuga')">
<a href="http://example.com">piyo</a>
</body>
</html>


