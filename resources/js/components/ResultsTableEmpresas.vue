<template>
  <div>
    <div class="table-wrapper" v-if="!error">
      <table class="cyber-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Razón social</th>
            <th>Municipio</th>
            <th>Departamento</th>
            <th>Actividades</th>
            <th>Fecha matrícula</th>
            <th>Dirección</th>
            <th>Rep. legal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loading" class="loading-row">
            <td colspan="8">Cargando resultados...</td>
          </tr>
          <tr v-else-if="rows.length === 0" class="empty-row">
            <td colspan="8">Sin resultados</td>
          </tr>
          <tr v-else v-for="r in rows" :key="r.id">
            <td>{{ r.id }}</td>
            <td>{{ r.razon_social }}</td>
            <td>{{ r.municipio }}</td>
            <td>{{ r.departamento }}</td>
            <td>
              <span v-for="(a, i) in r.actividades" :key="a.id">
                {{ a.nombre }}<span v-if="i < r.actividades.length - 1">, </span>
              </span>
            </td>
            <td>{{ formatDate(r.fecha_matricula) }}</td>
            <td>{{ r.direccion }}</td>
            <td>{{ r.rep_legal }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="error" v-else>{{ error }}</div>
  </div>
</template>

<script>
export default {
  name: "ResultsTableEmpresas",
  props: {
    rows: { type: Array, default: () => [] },
    loading: { type: Boolean, default: false },
    error: { type: String, default: "" },
  },
  methods: {
    formatDate(iso) {
      if (!iso) return "";
      try {
        const d = new Date(iso);
        return d.toLocaleDateString();
      } catch {
        return iso;
      }
    },
  },
};
</script>

<style scoped>
.table-wrapper {
  width: 100%;
  overflow: auto;
  border-radius: 4px;
  border: 1px solid var(--border);
}

.error {
  color: var(--error);
  text-align: center;
  padding: 2rem;
  background: var(--bg-tertiary);
  border-radius: 4px;
  border: 1px solid var(--error);
}
</style>