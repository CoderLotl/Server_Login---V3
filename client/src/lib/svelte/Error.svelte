<img src={sadFrog} class="logo frog" alt="dancing frog" />
<p>That place doesn't exist.</p>
<button id="back-btn" on:click={GoBack}>« Go back</button>

<script>
    import { navigate } from 'svelte-routing';    
    import { onMount } from 'svelte';
    import { GoBack } from '../js/utilities/backbtn';

    import sadFrog from '../../assets/sad-frog.jpg';

    onMount(() => {
        navigate('/error', { replace: true }); // Replace the current entry in the history stack
    });
</script>