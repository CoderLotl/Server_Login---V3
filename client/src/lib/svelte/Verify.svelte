<div id="verify-content">

</div>

<script>    
    import { onMount } from 'svelte';
    import { Verify } from '../js/scripts/verify';
    import '../js/scripts/verify.js';
    onMount( ()=>
    {
        Verify();
    });
</script>