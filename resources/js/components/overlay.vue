<template>
  <v-overlay
    :model-value="true"
    class="global-loader d-flex align-center justify-center"
    persistent
    scrim="rgba(255, 255, 255, 0.5)"
  >
    <div class="loader-box">
      <v-progress-circular
        indeterminate
        size="64"
        width="5"
        color="primary"
      />
      <p class="loader-text mt-4">Please wait...</p>
    </div>
  </v-overlay>
</template>

<style scoped>
.global-loader {
  backdrop-filter: blur(8px);
  z-index: 9999 !important;
}

.loader-box {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
  border-radius: 16px;
  padding: 40px 60px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
  text-align: center;
}

.loader-text {
  font-weight: 500;
  font-size: 1rem;
  color: #333;
}
</style>
