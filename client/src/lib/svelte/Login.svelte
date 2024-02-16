<title>Test Login with Svelte</title>

<form id="login">
    <input id="user" type="text" placeholder="User" autocomplete="off">
    <input id="password" type="password" placeholder="Password" autocomplete="off">
    <a href='/register' on:click={register} role="button" aria-label="Navigate to another component">
        Register an account
    </a>
    <button id="login-btn" on:click={Login}>Login</button>
</form>
<span id="response"></span>

<script>    
    import { navigate } from 'svelte-routing';
    import { Login } from '../js/scripts/login';

    function register(event) {
        event.preventDefault(); // Prevent default anchor behavior (navigation)
        navigate('/register');
    }
</script>
