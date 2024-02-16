<div id="register" class="el-r20">
    <form id="register-form" class="el-r20 p10 m20 fcolumn a-center">
        <input id="user" type="text" placeholder="User" autocomplete="off">
        <input id="mail" type="email" placeholder="Email" autocomplete="off">
        <input id="password" type="password" placeholder="Password" autocomplete="off">
        <div id="buttons-div">
            <button id="back-btn" on:click={GoBack}>« Go back</button>
            <button id="register-btn" on:click={Register}>Register</button>
        </div>
        <div id="r-response" class="fcolumn a-center">
            <span id="r-resp-img"></span>
            <p id="r-resp-msg"></p>
        </div>
    </form>
</div>

<script>
    import { onMount } from 'svelte';
    import { GoBack } from '../js/utilities/backbtn';
    import { Register } from '../js/utilities/register';

    onMount(() =>
    {
        document.getElementById('r-resp-img').className = '';
        document.getElementById('r-resp-msg').textContent = '';
    });
    
</script>