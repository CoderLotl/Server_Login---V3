<script>
    import { onMount } from 'svelte';
    import { Verify } from '../js/scripts/verify';
    import { GoBack } from '../js/utilities/backbtn';
    import '../js/scripts/verify.js';

    onMount(() => {
        Verify();
    });
</script>

<div id="verify-content">
    
</div>
<button on:click={GoBack}>Go Back</button>
