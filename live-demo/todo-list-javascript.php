<!doctype html>
<html lang="en">
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
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>To-do list - JavaScript</title>

   <style>
      ul {
         list-style: none;
         padding: 10px;
         margin: 10px;
         width: 40%;
         float: left;
         border: 1px solid #333;
         background: #eee;;
      }

      html, body {
         width: 100%;
         height: 100%;
         margin: 0;
         padding: 0;
      }

      h1, input, hr {
         margin: 10px;
      }

      #notice {
         display: block;
         position: absolute;
         bottom: 0;
         height: 45px;
         width: 100%;
         background: #74cfae;
         border-top: 5px solid #4F8371;
         padding: 0;
         margin: 0;
         color: #000;
         font-family: monospace;
      }

      #notice p {
         margin: 10px;
      }

   </style>
</head>
<body>

<h1>To-do list</h1>

<input type="text" id="input"/>
<button id="btn">ADD</button>

<hr/>

<ul id="todo"></ul>
<ul id="done"></ul>

<script>
   (function() {
      var input = document.getElementById('input');
      var btn = document.getElementById('btn');
      var lists = {
         todo: document.getElementById('todo'),
         done: document.getElementById('done')
      };

      /**
       *
       * @param {string} str
       * @param {Function} onCheck
       * @returns {HTMLElement}
       */
      var makeTaskHtml = function(str, onCheck) {
         var el = document.createElement('li');
         var checkbox = document.createElement('input');
         var label = document.createElement('span');

         checkbox.type = 'checkbox';
         checkbox.addEventListener('click', onCheck);
         label.textContent = str;

         el.appendChild(checkbox);
         el.appendChild(label);

         return el;
      };

      var addTask = function(task) {
         lists.todo.appendChild(task);
      };

      var onCheck = function(event) {
         var task = event.target.parentElement;
         var list = task.parentElement.id;

         lists[list === 'done' ? 'todo' : 'done'].appendChild(task);
         this.checked = false;
         input.focus();
      };

      var onInput = function() {
         var str = input.value.trim();

         if (str.length > 0) {
            addTask(makeTaskHtml(str, onCheck));

            input.value = '';
            input.focus();
         }
      };

      btn.addEventListener('click', onInput);
      input.addEventListener('keyup', function(event) {
         var code = event.keyCode;

         if (code === 13) {
            onInput();
         }
      });

      input.focus();
   }());
</script>



<script>
   (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
         (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o),
         m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
   })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

   ga('create', 'UA-36191661-1', 'easylearntutorial.com');
   ga('send', 'pageview');

</script>
<div id="notice">
   <p>
      &copy; <?= date('Y', time()); ?> <a href="/">EasyLearnTutorial</a>. All rights reserved.
   </p>
</div>
</body>
</html>
