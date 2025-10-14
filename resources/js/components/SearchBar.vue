<template>
  <div class="col">
    <label class="muted">Buscar</label>
    <div class="input-wrapper">
      <input
        class="input"
        type="text"
        :value="modelValue"
        @input="onInput"
        @keyup.enter="emitSearch"
        placeholder="Ej. ID, Razón social, Actividades...."
      />
      <span v-if="loading" class="spinner"></span>
    </div>

    <div class="row" style="justify-content: flex-end; gap: .5rem;">
      <button class="btn ghost" @click="clear" :disabled="loading">
        Limpiar
      </button>
      <button class="btn primary" @click="emitSearch" :disabled="loading">
        <template v-if="loading">
          <span class="btn-spinner"></span> Buscando...
        </template>
        <template v-else>
          Buscar
        </template>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  props: {
    modelValue: { type: String, default: '' },
    loading: { type: Boolean, default: false }
  },
  emits: ['update:modelValue', 'search', 'live'],
  methods: {
    onInput(e) {
      const val = e.target.value
      this.$emit('update:modelValue', val)
      this.$emit('live', val)
    },
    emitSearch() {
      this.$emit('search')
    },
    clear() {
      this.$emit('update:modelValue', '')
      this.$emit('live', '')
    }
  }
}
</script>

<style scoped>
.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.input-wrapper .input {
  width: 100%;
  padding-right: 2rem;
}
.spinner {
  position: absolute;
  right: 0.5rem;
  width: 1rem;
  height: 1rem;
  border: 2px solid #ccc;
  border-top-color: #007bff;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
}
.btn-spinner {
  display: inline-block;
  width: 1rem;
  height: 1rem;
  margin-right: 0.5rem;
  border: 2px solid #fff;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
  vertical-align: middle;
}
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
