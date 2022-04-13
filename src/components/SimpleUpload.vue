<template>
   <form @submit.prevent="sendFile" enctype="multipart/form-data">
      <div v-if="message" :class="`message ${error ? 'is-danger' : 'is-success'}`">
         <div class="message-body">{{message}}</div>
      </div>

      <div v-if="uploading" class="field">
         <progress class="progress is-primary" :value="progress" max="100"></progress>
      </div>

      <div class="field">
         <div class="file is-boxed is-primary">
            <label class="file-label">

               <input
                  type="file"
                  ref="file"
                  @change="selectFile"
                  class="file-input"
               >

               <span class="file-cta">
                  <span class="file-icon">
                     <i class="fas fa-upload"></i>
                  </span>
                   <span class="file-label">Choose a file...</span>
               </span>

               <span v-if="file" class="file-name">{{file.name}}</span>

            </label>
         </div>
      </div>

      <div class="field">
         <button class="button is-info">Upload</button>
      </div>

   </form>
</template>

<script>
import axios from 'axios';
export default {
   name: "simple-upload",
   data() {
      return {
         file: '',
         uploading: false,
         progress: 0,
         message: '',
         error: false
      }
   },
   methods: {
      selectFile() {
         this.file = this.$refs.file.files[0];
         this.error = false;
         this.message = '';
         this.uploading = false;
         this.progress = 0;
      },
      async sendFile() {
         const formData = new FormData();
         formData.append('file', this.file);
         this.uploading = true;
         this.progress = 0;

         try {
            const {data} = await axios.post('/upload.php', formData, {
               onUploadProgress: progressEvent => {
                  this.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
               }
            });
            this.message = `File has ${data.success ? '' : 'not'} been uploaded!`;
            this.file = '';
            this.error = !data.success;
         } catch (e) {
            this.message = 'Something went wrong!';
            this.error = true;
         }
      }
   }
}
</script>
