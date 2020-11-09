<!DOCTYPE html>
<html lang="en">
<head>
<title>ACE in Action</title>
<style type="text/css" media="screen">
    #editor { 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12">
        <div id="editor">def foo(items) {
            x = "All this is syntax highlighted";
            return x;
        }</div>
    </div>
    </div>
</div>

    
<script src="{{asset('js\ace.js')}}" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/dracula");
    editor.session.setMode("ace/mode/python");
</script>
</body>
</html>