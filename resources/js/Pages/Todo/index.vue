<template>
  <div>
    <Head title="Vue.js • TodoMVC" />
    <section class="todoapp">
        <header class="header">
            <h1>todos</h1>
            <form @submit.prevent="form.post('/todo')">
                <input class="new-todo" autofocus autocomplete="off" placeholder="What needs to be done?" v-model="form.title">
            </form>
        </header>
        <section class="main" v-show="todos.length">
            <form @submit.prevent="form.put('/todo')">
                <input id="toggle-all" class="toggle-all" type="checkbox" v-model="form.allDone">
                <label for="toggle-all">Mark all as complete</label>
            </form>
            <ul class="todo-list">
                <li class="todo" v-for="todo in todos" :key="todo.id" :class="{completed: todo.completed, editing: todo == form.editedTodo}">
                    <div class="view">
                        <input class="toggle" type="checkbox" v-model="todo.completed" @change="editTodo(todo)">
                        <label @dblclick="editTodo(todo)">{{todo.title}}</label>
                        <button class="destroy" @click="removeTodo(todo)"></button>
                    </div>
                    <input class="edit" type="text" v-model="todo.title" v-todo-focus="todo == form.editedTodo" @blur="doneEdit(todo)" @keydown.enter="doneEdit(todo)" @keydown.esc="cancelEdit(todo)">
                </li>
            </ul>
        </section>
        <footer class="footer" v-show="todos.length">
            <span class="todo-count">
                <strong v-text="left"></strong> {{pluralize('item', left)}} left
            </span>
            <ul class="filters">
                <li>
                    <Link href="/todo" :class="{selected: type == 'all'}" :data="{type:'all'}">All</Link>
                </li>
                <li>
                    <Link href="/todo" :class="{selected: type == 'active'}" :data="{type:'active'}">Active</Link>
                </li>
                <li>
                    <Link href="/todo" :class="{selected: type == 'completed'}" :data="{type:'completed'}">Completed</Link>
                </li>
            </ul>
            <Link href="/todo/delComplete" class="clear-completed" as="button" method="delete" type="button" v-show="todos.length > left">Clear completed</Link>
        </footer>
    </section>
    <footer class="info">
        <p>Double-click to edit a todo</p>
        <p>Written by <a href="http://evanyou.me">Evan You</a></p>
        <p>Part of <a href="http://todomvc.com">TodoMVC</a></p>
    </footer>
  </div>
</template>

<script>
import { Head, Link, useForm} from '@inertiajs/vue2'
export default {
    components: {
        Head,
        Link
    },
    data() {
        return {
            beforeEditCache: '',
            form: useForm({
                title: '',
                editedTodo: {},
                type: 'all',
            }),
        }
    },
    methods:{
        pluralize: function (word, count) {
            return word + (count === 1 ? '' : 's');
        },
        removeTodo: function (todo) {
            this.form.delete('/todo?id='+todo.id, {
                data:{
                    id:todo.id
                }
            })
        },

        editTodo: function (todo) {
            this.beforeEditCache = todo.title;
            this.form.editedTodo = todo;
            this.form.put('/todo', {
                data:{
                    editedTodo:todo
                }
            })
        },

        doneEdit: function (todo) {
            if (!this.form.editedTodo) {
                return;
            }
            this.form.editedTodo = null;
            todo.title = todo.title.trim();
            if (!todo.title) {
                this.removeTodo(todo);
            }
        },

        cancelEdit: function (todo) {
            this.form.editedTodo = null;
            todo.title = this.beforeEditCache;
        },
    },
    props: {
    todos: {
        type: Array,
    },
    title: {
        type: String
    },
    editedTodo:{
        type:Object,
        default: null
    },
    type: {
        type:String,
        default: 'all'
    },
    left:{
        type:Number,
    }
    },
    directives: {
        'todo-focus': function (el, binding) {
            if (binding.value) {
                el.focus();
            }
        }
    }
}
</script>

