<script setup lang="ts">
import {ref, watch} from 'vue';

const { src } = defineProps<{
  src: string | undefined
}>();

const emit = defineEmits();
const modal = ref<boolean>(false);
const tab = ref<"uploader"|"camera">("uploader");

function handleUpload(event:any) {
  if(event.target?.files?.length) {
    emit('handleUpload', event.target?.files?.[0]);
    modal.value = false;
    stop();
  }
}

const stream = ref()

const start = async() => stream.value = await navigator.mediaDevices.getUserMedia(constraints)
const stop = () => stream.value.getTracks().forEach(track => track.stop());

const constraints = {
  audio: false,
  video: {
    width: { min: 1024, ideal: 1280, max: 1920 },
    height: { min: 576, ideal: 720, max: 1080 },
    facingMode: 'environment',
  },
}

const capture = async () => {
  const track = stream.value.getTracks()[0];
  const imageCapture = new ImageCapture(track);
  const blob = await imageCapture.takePhoto();
  const file = await new File([blob], `${Date.now()}.jpg`, {type: "image/jpeg"});
  emit('handleUpload', file);
  modal.value = false;
  stop();
}

watch(tab, (value) => {
  if(value === 'camera') {
    start();
  } else {
    stop();
  }
});
</script>
<template>
  <v-avatar rounded="0" color="primary" class="w-100 h-100 rounded cursor-pointer" @click="modal=true" >
    <v-img aspect-ratio="16/9" cover :src="src" v-if="src"/>
    <v-icon icon="mdi-camera" v-else/>
  </v-avatar>
  
  <v-dialog v-model="modal" width="600">
    <v-card>
      <v-tabs v-model="tab" color="primary" grow>
        <v-tab key="uploader" value="uploader">Uploader</v-tab>
        <v-tab key="camera" value="camera">Camera</v-tab>
      </v-tabs>
      
      <v-window v-model="tab">
        
        <v-window-item key="uploader" value="uploader">
          <v-card flat class="pa-2">
            <label for="uploader" class="cursor-pointer">
              <v-hover>
                <template v-slot:default="{ isHovering, props }">
                  <v-avatar v-bind="props" :class="`w-100 h-100 border-dashed h-75 ${isHovering? 'bg-grey-lighten-4':''} rounded`" style="min-height: 180px;" rounded="0">
                    <v-icon icon="mdi-upload"/>
                    <span class="mx-2">Upload Photo</span>
                  </v-avatar>
                  <input type="file" @change="handleUpload" id="uploader" style="display: none;"/>
                </template>
              </v-hover>
            </label>
          </v-card>
        </v-window-item>

        <v-window-item key="camera" value="camera">
          <video class="" :srcObject="stream" width="600" autoplay></video>
          <v-card flat class="ma-4">
            <div class="d-flex">
              <v-btn @click="capture" color="primary" class="mx-auto">
                capture
              </v-btn>
            </div>
          </v-card>
        </v-window-item>

      </v-window>
    </v-card>
  </v-dialog>

</template>