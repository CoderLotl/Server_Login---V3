<script context="module">
    import { navigate } from 'svelte-routing';
    export function NavTo(location)
    {
        navigate(`/${location}`, {replace: true});
    }
</script>