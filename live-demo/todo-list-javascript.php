<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <!--

                         ___           ___           ___
                        /\__\         /\  \         /\__\
                       /:/ _/_       /::\  \       /:/ _/_         ___
                      /:/ /\__\     /:/\:\  \     /:/ /\  \       /|  |
                     /:/ /:/ _/_   /:/ /::\  \   /:/ /::\  \     |:|  |
                    /:/_/:/ /\__\ /:/_/:/\:\__\ /:/_/:/\:\__\    |:|  |
                    \:\/:/ /:/  / \:\/:/  \/__/ \:\/:/ /:/  /  __|:|__|
                     \::/_/:/  /   \::/__/       \::/ /:/  /  /::::\  \
                      \:\/:/  /     \:\  \        \/_/:/  /   ~~~~\:\  \
                       \::/  /       \:\__\         /:/  /         \:\__\
                        \/__/         \/__/         \/__/           \/__/
                              ___           ___           ___           ___
                             /\__\         /\  \         /\  \         /\  \
                            /:/ _/_       /::\  \       /::\  \        \:\  \
                           /:/ /\__\     /:/\:\  \     /:/\:\__\        \:\  \
            ___     ___   /:/ /:/ _/_   /:/ /::\  \   /:/ /:/  /    _____\:\  \
           /\  \   /\__\ /:/_/:/ /\__\ /:/_/:/\:\__\ /:/_/:/__/___ /::::::::\__\
           \:\  \ /:/  / \:\/:/ /:/  / \:\/:/  \/__/ \:\/:::::/  / \:\~~\~~\/__/
            \:\  /:/  /   \::/_/:/  /   \::/__/       \::/~~/~~~~   \:\  \
             \:\/:/  /     \:\/:/  /     \:\  \        \:\~~\        \:\  \
              \::/  /       \::/  /       \:\__\        \:\__\        \:\__\
               \/__/         \/__/         \/__/         \/__/         \/__/
                     ___                         ___           ___                       ___
                    /\  \                       /\  \         /\  \                     /\  \
       ___          \:\  \         ___         /::\  \       /::\  \       ___         /::\  \
      /\__\          \:\  \       /\__\       /:/\:\  \     /:/\:\__\     /\__\       /:/\:\  \
     /:/  /      ___  \:\  \     /:/  /      /:/  \:\  \   /:/ /:/  /    /:/__/      /:/ /::\  \   ___     ___
    /:/__/      /\  \  \:\__\   /:/__/      /:/__/ \:\__\ /:/_/:/__/___ /::\  \     /:/_/:/\:\__\ /\  \   /\__\
   /::\  \      \:\  \ /:/  /  /::\  \      \:\  \ /:/  / \:\/:::::/  / \/\:\  \__  \:\/:/  \/__/ \:\  \ /:/  /
  /:/\:\  \      \:\  /:/  /  /:/\:\  \      \:\  /:/  /   \::/~~/~~~~   ~~\:\/\__\  \::/__/       \:\  /:/  /
  \/__\:\  \      \:\/:/  /   \/__\:\  \      \:\/:/  /     \:\~~\          \::/  /   \:\  \        \:\/:/  /
       \:\__\      \::/  /         \:\__\      \::/  /       \:\__\         /:/  /     \:\__\        \::/  /
        \/__/       \/__/           \/__/       \/__/         \/__/         \/__/       \/__/         \/__/

   + + + + + + +----------------------  http://www.easylearntutorial.com  ----------------------+ + + + + + +

 (c) 2014 Rodrigo Silveira. All rights reserved.

 -->
    <title>To-do List in JavaScript</title>
    <style>
        .tasks {
            list-style: none;
            padding: 10px;
            margin: 10px;
            border: 1px solid #333;
            background: #eee;
            width: 40%;
            float: left;
        }
    </style>
<body>

<h1>To-do list</h1>

<input type="text" id="input"/>
<button id="btnAdd">ADD</button>
<hr/>
<ul class="tasks" id="undone"></ul>
<ul class="tasks" id="done"></ul>


<script>
    (function() {
        var input = document.getElementById('input');
        var btn = document.getElementById('btnAdd');
        var lists = {
            done: document.getElementById('done'),
            undone: document.getElementById('undone')
        };

        var makeTask = function(str, onCheck) {
            var el = document.createElement('li');
            var label = document.createElement('span');
            var check = document.createElement('input');

            onCheck = onCheck || function(){};

            label.textContent = str;
            check.type = 'checkbox';
            check.addEventListener('click', onCheck, false);

            el.appendChild(check);
            el.appendChild(label);

            return el;
        }

        var addTask = function(list, item) {
            list.appendChild(item);
        };

        var onCheck = function(event) {
            var task = event.target.parentElement;
            var list = task.parentElement.getAttribute('id');
            var target = list === 'done' ? 'undone' : 'done';

            this.checked = false;

            lists[target].appendChild(task);
            input.focus();
        };

        var addNewTask = function(){
            var task = input.value.trim();

            if (task.length > 0) {
                addTask(lists.undone, makeTask(task, onCheck));
                input.value = '';
                input.focus();
            }
        };

        btn.addEventListener('click', addNewTask, false);
        input.addEventListener('keyup', function(e){
            if (e.keyCode === 13) {
                addNewTask();
            }
        });
        input.focus();
    }());
</script>
</body>
</html>
