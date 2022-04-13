<template>
   <div class="section">
      <div class="container">
         <simple-upload></simple-upload>
      </div>
   </div>
</template>

<script>
import SimpleUpload from './components/SimpleUpload'

export default {
   name: 'App',
   components: { SimpleUpload }
}
</script>