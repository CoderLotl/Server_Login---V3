<div id="css-container"></div>
<script>
// @ts-nocheck

  // IMPORTS
  import { Router, Route } from 'svelte-routing';    

  // COMPONENTS
  import Home from './lib/svelte/Home.svelte';
  import Login from './lib/svelte/Login.svelte';
  import Register from './lib/svelte/Register.svelte';
  import Verify from './lib/svelte/Verify.svelte';
  import Error from './lib/svelte/Error.svelte';

  const routes = [
    { path: '/home', component: Home },
    { path: '/', component: Login },
    { path: '/register', component: Register },
    { path: '/verify/:code', component: Verify},
    // Add other routes here
    { path: '*', component: Error } // Catch-all route
  ];

</script>

<Router>
  {#each routes as { path, component }}
    <Route {path} let:params>
        <svelte:component this={component} {...params} />
    </Route>
  {/each}
</Router>