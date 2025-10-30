<template>
  <div>
    <div class="table-wrapper" v-if="!error">
      <table class="cyber-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Razón Social</th>
            <th>Ubicación</th>
            <th>Actividades</th>
            <th>Fecha</th>
            <th>Contacto</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loading">
            <td colspan="6" class="loading-row">
              <div class="loading-cell">🔄 Cargando...</div>
            </td>
          </tr>
          <tr v-else-if="rows.length === 0">
            <td colspan="6" class="empty-row">
              <div class="empty-cell">📭 No hay resultados</div>
            </td>
          </tr>
          <tr v-else v-for="r in rows" :key="r.id" class="data-row">
            <td class="cell-id">{{ r.id }}</td>
            <td class="cell-razon-social">
              <strong>{{ r.razon_social }}</strong>
              <div class="rep-legal" v-if="r.rep_legal">{{ r.rep_legal }}</div>
            </td>
            <td class="cell-ubicacion">
              <div>{{ r.municipio }}</div>
              <div class="departamento">{{ r.departamento }}</div>
            </td>
            <td class="cell-actividades">
              <span v-for="(a, i) in r.actividades" :key="a.id">
                {{ a.nombre }}<span v-if="i < r.actividades.length - 1">, </span>
              </span>
            </td>
            <td class="cell-fecha">{{ formatDate(r.fecha_matricula) }}</td>
            <td class="cell-contacto">
              <div class="direccion">{{ r.direccion }}</div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else class="error-message">
      ⚠️ {{ error }}
    </div>
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
        return new Date(iso).toLocaleDateString('es-ES');
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
  border-radius: 8px;
  border: 1px solid var(--border);
  background: var(--bg-secondary);
}

.cyber-table {
  width: 100%;
  border-collapse: collapse;
}

.cyber-table th {
  background: var(--bg-tertiary);
  padding: 1rem;
  text-align: left;
  font-weight: 600;
  color: var(--accent);
  border-bottom: 2px solid var(--border);
}

.cyber-table td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid var(--border);
}

.data-row:hover {
  background: var(--bg-tertiary);
}

.loading-row, .empty-row {
  text-align: center;
}

.loading-cell, .empty-cell {
  padding: 2rem;
  color: var(--text-muted);
  font-style: italic;
}

.cell-id {
  font-family: 'Courier New', monospace;
  font-weight: bold;
  color: var(--text-muted);
}

.cell-razon-social strong {
  color: var(--accent);
}

.rep-legal {
  font-size: 0.8rem;
  color: var(--text-muted);
  margin-top: 0.25rem;
}

.departamento {
  font-size: 0.8rem;
  color: var(--text-muted);
}

.cell-actividades {
  max-width: 200px;
  font-size: 0.85rem;
}

.cell-fecha {
  font-family: 'Courier New', monospace;
  font-size: 0.85rem;
  white-space: nowrap;
}

.direccion {
  font-size: 0.85rem;
  max-width: 150px;
  overflow: hidden;
  text-overflow: ellipsis;
}

.error-message {
  background: var(--error-bg);
  color: var(--error);
  padding: 1.5rem;
  border-radius: 8px;
  border: 1px solid var(--error);
  text-align: center;
  font-weight: 500;
}

@media (max-width: 768px) {
  .cyber-table {
    font-size: 0.8rem;
  }
  
  .cyber-table th,
  .cyber-table td {
    padding: 0.5rem;
  }
  
  .cell-actividades,
  .direccion {
    max-width: 120px;
  }
}
</style>