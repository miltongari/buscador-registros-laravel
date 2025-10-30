<template>
    <div class="app" :class="[currentTheme, { loading: loading }]">
        <header class="cyber-header">
            <div class="header-glitch" data-text="BUSCADOR DE EMPRESAS">
                BUSCADOR DE EMPRESAS
            </div>
            <div class="theme-controls">
                <select
                    class="cyber-select"
                    v-model="selectedTheme"
                    @change="changeTheme"
                >
                    <option value="theme-cyberpunk">🔮 Cyberpunk 2077</option>

                    <option value="theme-matrix">💚 Matrix</option>
                    <option value="theme-neon">💜 Neon</option>
                    <option value="theme-gruvbox-dark">🌙 Gruvbox Dark</option>
                    <option value="theme-gruvbox-light">
                        ☀️ Gruvbox Light
                    </option>
                    <option value="theme-profesional">💼 Profesional</option>
                    <option value="theme-profesional-minimal">
                        ⚡ Profesional Minimal
                    </option>

                    <option value="theme-ultra-profesional">
                        🏢 Ultra Profesional
                    </option>
                </select>
            </div>
        </header>

        <div class="cyber-grid">
            <!-- Panel de control - Filtros y configuración -->
            <div class="cyber-panel control-panel">
                <!-- Búsqueda principal -->
                <div class="cyber-section">
                    <label class="cyber-label">BÚSQUEDA PRINCIPAL</label>
                    <SearchBar
                        :modelValue="query"
                        :loading="loading"
                        @update:modelValue="onQueryUpdate"
                        @search="searchNow"
                    />
                </div>

                <!-- Sección de Filtros Avanzados -->
                <div class="cyber-section" v-if="rows.length > 0">
                    <label class="cyber-label">FILTROS AVANZADOS</label>

                    <div class="filters-grid">
                        <!-- Filtro por Departamento -->
                        <div class="filter-group">
                            <label>Departamento:</label>
                            <select
                                v-model="advancedFilters.departamento"
                                @change="applyAdvancedFilters"
                                class="cyber-select small"
                            >
                                <option value="">
                                    Todos los departamentos
                                </option>
                                <option
                                    v-for="dept in uniqueDepartments"
                                    :key="dept"
                                    :value="dept"
                                >
                                    {{ dept }}
                                </option>
                            </select>
                        </div>

                        <!-- Filtro por Municipio -->
                        <div class="filter-group">
                            <label>Municipio:</label>
                            <select
                                v-model="advancedFilters.municipio"
                                @change="applyAdvancedFilters"
                                class="cyber-select small"
                            >
                                <option value="">Todos los municipios</option>
                                <option
                                    v-for="mun in uniqueMunicipios"
                                    :key="mun"
                                    :value="mun"
                                >
                                    {{ mun }}
                                </option>
                            </select>
                        </div>

                        <!-- Filtro por Actividad Económica -->
                        <div class="filter-group">
                            <label>Actividad:</label>
                            <select
                                v-model="advancedFilters.actividad"
                                @change="applyAdvancedFilters"
                                class="cyber-select small"
                            >
                                <option value="">Todas las actividades</option>
                                <option
                                    v-for="act in uniqueActivities"
                                    :key="act"
                                    :value="act"
                                >
                                    {{ act }}
                                </option>
                            </select>
                        </div>

                        <!-- Filtro por Rango de Fechas -->
                        <!-- <div class="filter-group">
                            <label>Fecha desde:</label>
                            <input type="date" v-model="advancedFilters.fechaInicio" 
                                   @change="applyAdvancedFilters" class="cyber-input small">
                        </div> -->

                        <!-- <div class="filter-group">
                            <label>Fecha hasta:</label>
                            <input type="date" v-model="advancedFilters.fechaFin" 
                                   @change="applyAdvancedFilters" class="cyber-input small">
                        </div> -->
                    </div>

                    <!-- Indicador de filtros activos -->
                    <div class="filters-status" v-if="activeFiltersCount > 0">
                        <span class="filter-badge"
                            >{{ activeFiltersCount }} filtro(s)
                            aplicado(s)</span
                        >
                        <button
                            @click="clearAllFilters"
                            class="clear-filters-btn"
                        >
                            Limpiar filtros
                        </button>
                    </div>
                </div>

                <!-- Panel de estadísticas -->
                <div class="cyber-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ total }}</div>
                        <div class="stat-label">REGISTROS TOTALES</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ filteredRows.length }}</div>
                        <div class="stat-label">RESULTADOS FILTRADOS</div>
                    </div>
                    <div class="stat-item" v-if="activeFiltersCount > 0">
                        <div class="stat-value">{{ activeFiltersCount }}</div>
                        <div class="stat-label">FILTROS ACTIVOS</div>
                    </div>
                </div>

                <!-- Configuración de visualización -->
                <div class="cyber-section">
                    <label class="cyber-label">CONFIGURACIÓN</label>
                    <div class="config-row">
                        <span>Resultados por página:</span>
                        <select
                            class="cyber-select"
                            v-model.number="pageSize"
                            @change="searchNow"
                        >
                            <option :value="10">10</option>
                            <option :value="20">20</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                        </select>
                    </div>
                </div>

                <!-- Acciones de exportación -->
                <div class="cyber-section">
                    <label class="cyber-label">ACCIONES</label>
                    <div class="action-grid">
                        <ExportButton :rows="filteredRows" />
                        <button
                            class="cyber-button secondary"
                            @click="resetAll"
                            :disabled="loading"
                        >
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel de resultados -->
            <div class="cyber-panel results-panel">
                <div class="results-header">
                    <h3 class="cyber-title">
                        RESULTADOS
                        <span
                            v-if="activeFiltersCount > 0"
                            class="filter-indicator"
                        >
                            (con filtros aplicados)
                        </span>
                    </h3>
                    <div class="pagination-info">
                        <span class="cyber-text"
                            >Página {{ page }} de {{ totalPages }}</span
                        >
                    </div>
                </div>

                <!-- Tabla de resultados -->
                <div class="table-container">
                    <ResultsTableEmpresas
                        :rows="filteredRows"
                        :loading="loading"
                        :error="error"
                    />
                </div>

                <!-- Control de paginación -->
                <div class="cyber-pagination" v-if="totalPages > 1">
                    <button
                        class="cyber-button pagination-btn"
                        :disabled="page <= 1"
                        @click="changePage(page - 1)"
                    >
                        ‹ Anterior
                    </button>
                    <div class="page-indicator">
                        <span class="current-page">{{ page }}</span>
                        <span class="page-separator">/</span>
                        <span class="total-pages">{{ totalPages }}</span>
                    </div>
                    <button
                        class="cyber-button pagination-btn"
                        :disabled="page >= totalPages"
                        @click="changePage(page + 1)"
                    >
                        Siguiente ›
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import debounce from "./utils/debounce";
import { empresasService } from "./services/api";
import SearchBar from "./components/SearchBar.vue";
import ResultsTableEmpresas from "./components/ResultsTableEmpresas.vue";
import ExportButton from "./components/ExportButton.vue";

export default {
    name: "App",
    components: { SearchBar, ResultsTableEmpresas, ExportButton },
    data() {
        return {
            // Parámetros de búsqueda principal
            query: "",
            page: 1,
            pageSize: 20,
            total: 0,
            rows: [],
            loading: false,
            error: "",
            selectedTheme: "theme-cyberpunk",

            // Configuración de filtros avanzados
            advancedFilters: {
                departamento: "",
                municipio: "",
                actividad: "",
                fechaInicio: null,
                fechaFin: null,
            },

            // Instancia de debounce para búsquedas
            debouncedSearch: null,
        };
    },
    computed: {
        /**
         * Calcula el total de páginas basado en los resultados
         */
        totalPages() {
            return Math.max(1, Math.ceil(this.total / this.pageSize));
        },

        /**
         * Retorna el tema actual de la aplicación
         */
        currentTheme() {
            return this.selectedTheme;
        },

        /**
         * Aplica los filtros avanzados a los resultados
         * Filtra por departamento, municipio, actividad y rango de fechas
         */
        filteredRows() {
            let filtered = this.rows;

            // Filtro por departamento
            if (this.advancedFilters.departamento) {
                filtered = filtered.filter(
                    (emp) =>
                        emp.departamento === this.advancedFilters.departamento
                );
            }

            // Filtro por municipio
            if (this.advancedFilters.municipio) {
                filtered = filtered.filter(
                    (emp) => emp.municipio === this.advancedFilters.municipio
                );
            }

            // Filtro por actividad económica
            if (this.advancedFilters.actividad) {
                filtered = filtered.filter((emp) =>
                    emp.actividades?.some((act) =>
                        act.nombre.includes(this.advancedFilters.actividad)
                    )
                );
            }

            // Filtro por rango de fechas
            if (this.advancedFilters.fechaInicio) {
                filtered = filtered.filter(
                    (emp) =>
                        new Date(emp.fecha_matricula) >=
                        new Date(this.advancedFilters.fechaInicio)
                );
            }

            if (this.advancedFilters.fechaFin) {
                filtered = filtered.filter(
                    (emp) =>
                        new Date(emp.fecha_matricula) <=
                        new Date(this.advancedFilters.fechaFin)
                );
            }

            return filtered;
        },

        /**
         * Lista de departamentos únicos para el filtro
         * Extraído de los datos cargados
         */
        uniqueDepartments() {
            return [
                ...new Set(
                    this.rows.map((emp) => emp.departamento).filter(Boolean)
                ),
            ].sort();
        },

        /**
         * Lista de municipios únicos para el filtro
         * Extraído de los datos cargados
         */
        uniqueMunicipios() {
            return [
                ...new Set(
                    this.rows.map((emp) => emp.municipio).filter(Boolean)
                ),
            ].sort();
        },

        /**
         * Lista de actividades económicas únicas
         * Extraída de los datos de actividades de las empresas
         */
        uniqueActivities() {
            const allActivities = this.rows.flatMap(
                (emp) => emp.actividades?.map((act) => act.nombre) || []
            );
            return [...new Set(allActivities)].sort();
        },

        /**
         * Contador de filtros activos actualmente
         * Utilizado para mostrar el estado de filtrado
         */
        activeFiltersCount() {
            return Object.values(this.advancedFilters).filter(
                (val) => val !== "" && val !== null
            ).length;
        },
    },
    created() {
        // Inicializa el debounce para búsquedas en tiempo real
        this.debouncedSearch = debounce(this.performSearch, 400);
        this.loadTheme();
        this.searchNow();
    },
    beforeUnmount() {
        // Limpia el timeout del debounce al destruir el componente
        if (this.debouncedSearch) {
            this.debouncedSearch.cancel();
        }
    },
    methods: {
        /**
         * Ejecuta la búsqueda en la API
         * Maneja estados de carga y errores
         */
        async fetchResults() {
            this.loading = true;
            this.error = "";
            try {
                const params = {
                    q: this.query,
                    page: this.page,
                    limit: this.pageSize,
                };

                const { data } = await empresasService.buscar(params);

                if (data?.ok) {
                    this.rows = data.rows || [];
                    this.total = data.total || 0;
                } else {
                    this.rows = [];
                    this.total = 0;
                    this.error = "Formato de respuesta inválido";
                }
            } catch (err) {
                console.error("Error en la búsqueda:", err);
                this.error = "Error de conexión con el servidor";
                this.rows = [];
                this.total = 0;
            } finally {
                this.loading = false;
            }
        },

        /**
         * Ejecuta la búsqueda inmediata
         * Cancela cualquier búsqueda pendiente
         */
        searchNow() {
            if (this.debouncedSearch) {
                this.debouncedSearch.cancel();
            }
            this.page = 1;
            this.fetchResults();
        },

        /**
         * Cambia a la página especificada
         * @param {number} newPage - Número de página destino
         */
        changePage(newPage) {
            if (newPage === this.page) return;
            this.page = newPage;
            this.fetchResults();
        },

        /**
         * Maneja la actualización del query con debounce
         * @param {string} val - Valor del campo de búsqueda
         */
        onQueryUpdate(val) {
            this.query = val;
            this.page = 1;
            this.debouncedSearch();
        },

        /**
         * Aplica los filtros avanzados
         * Reinicia la paginación al aplicar nuevos filtros
         */
        applyAdvancedFilters() {
            this.page = 1;
        },

        /**
         * Limpia todos los filtros aplicados
         * Reinicia el estado de filtrado
         */
        clearAllFilters() {
            this.advancedFilters = {
                departamento: "",
                municipio: "",
                actividad: "",
                fechaInicio: null,
                fechaFin: null,
            };
        },

        /**
         * Resetea completamente la búsqueda
         * Limpia query y filtros
         */
        resetAll() {
            if (this.debouncedSearch) {
                this.debouncedSearch.cancel();
            }
            this.query = "";
            this.page = 1;
            this.clearAllFilters();
            this.fetchResults();
        },

        /**
         * Wrapper para el método debounced de búsqueda
         */
        performSearch() {
            this.fetchResults();
        },

        /**
         * Cambia el tema de la aplicación
         * Persiste la selección en localStorage
         */
        changeTheme() {
            localStorage.setItem("selectedTheme", this.selectedTheme);
        },

        /**
         * Carga el tema guardado desde localStorage
         */
        loadTheme() {
            const savedTheme = localStorage.getItem("selectedTheme");
            if (savedTheme) {
                this.selectedTheme = savedTheme;
            }
        },
    },
};
</script>

<style scoped>
/* Estilos para el layout principal */
.app {
    min-height: 100vh;
    background: var(--bg-primary);
}

.cyber-grid {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Estilos para paneles */
.cyber-panel {
    background: var(--bg-secondary);
    border-radius: 8px;
    border: 1px solid var(--border);
    padding: 1.5rem;
}

.control-panel {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.results-panel {
    min-height: 600px;
}

/* Estilos para secciones */
.cyber-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.cyber-label {
    font-weight: 600;
    color: var(--accent);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Sistema de filtros */
.filters-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
}

.cyber-select.small,
.cyber-input.small {
    font-size: 0.8rem;
    padding: 0.5rem;
    border-radius: 4px;
}

/* Estado de filtros */
.filters-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: var(--bg-tertiary);
    border-radius: 4px;
    border: 1px solid var(--border);
}

.filter-badge {
    font-size: 0.8rem;
    color: var(--accent);
    font-weight: 500;
}

.clear-filters-btn {
    background: none;
    border: 1px solid var(--error);
    color: var(--error);
    padding: 0.25rem 0.5rem;
    border-radius: 3px;
    font-size: 0.7rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.clear-filters-btn:hover {
    background: var(--error);
    color: white;
}

/* Estadísticas */
.cyber-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: var(--bg-tertiary);
    border-radius: 6px;
    border: 1px solid var(--border);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--accent);
}

.stat-label {
    font-size: 0.7rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Configuración */
.config-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Acciones */
.action-grid {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 0.5rem;
}

/* Header de resultados */
.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border);
}

.cyber-title {
    color: var(--accent);
    margin: 0;
}

.filter-indicator {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: normal;
}

/* Paginación */
.cyber-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.page-indicator {
    color: var(--text-muted);
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .cyber-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
        padding: 1rem;
    }

    .cyber-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .action-grid {
        grid-template-columns: 1fr;
    }

    .results-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>
