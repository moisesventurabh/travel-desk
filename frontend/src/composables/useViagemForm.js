import { reactive, computed } from 'vue';
const DEPARTAMENTOS = ['TI', 'Comercial', 'Financeiro', 'RH', 'Operações', 'Diretoria'];
const DESTINOS_SUGERIDOS = [
    'São Paulo – SP', 'Rio de Janeiro – RJ', 'Brasília – DF',
    'Salvador – BA', 'Curitiba – PR', 'Florianópolis – SC',
    'Fortaleza – CE', 'Porto Alegre – RS', 'Recife – PE',
    'Manaus – AM', 'Belém – PA', 'Goiânia – GO',
];
export function useViagemForm() {
    // ─── Estado do formulário ────────────────────────────────
    const form = reactive({
        solicitante: '',
        destino: '',
        dataIda: '',
        dataVolta: '',
        objetivo: '',
        departamento: '',
    });
    const errors = reactive({});
    const touched = reactive({});
    // ─── Validação ───────────────────────────────────────────
    function validarCampo(campo) {
        switch (campo) {
            case 'solicitante':
                if (!form.solicitante.trim())
                    return 'Nome do solicitante é obrigatório.';
                if (form.solicitante.trim().length < 3)
                    return 'Nome deve ter ao menos 3 caracteres.';
                return '';
            case 'destino':
                if (!form.destino.trim())
                    return 'Destino é obrigatório.';
                return '';
            case 'dataIda': {
                if (!form.dataIda)
                    return 'Data de ida é obrigatória.';
                const hoje = new Date().toISOString().split('T')[0];
                if (form.dataIda < hoje)
                    return 'Data de ida não pode ser no passado.';
                return '';
            }
            case 'dataVolta': {
                if (!form.dataVolta)
                    return 'Data de volta é obrigatória.';
                if (form.dataIda && form.dataVolta < form.dataIda)
                    return 'Data de volta deve ser após a data de ida.';
                return '';
            }
            default:
                return '';
        }
    }
    function validarTodos() {
        const campos = ['solicitante', 'destino', 'dataIda', 'dataVolta'];
        let valido = true;
        campos.forEach(campo => {
            const msg = validarCampo(campo);
            if (msg) {
                errors[campo] = msg;
                valido = false;
            }
            else {
                delete errors[campo];
            }
            touched[campo] = true;
        });
        return valido;
    }
    function onBlur(campo) {
        touched[campo] = true;
        const msg = validarCampo(campo);
        if (msg)
            errors[campo] = msg;
        else
            delete errors[campo];
    }
    function resetar() {
        Object.assign(form, {
            solicitante: '', destino: '', dataIda: '',
            dataVolta: '', objetivo: '', departamento: '',
        });
        Object.keys(errors).forEach(k => delete errors[k]);
        Object.keys(touched).forEach(k => delete touched[k]);
    }
    // ─── Computed helpers ────────────────────────────────────
    const isValido = computed(() => {
        const campos = ['solicitante', 'destino', 'dataIda', 'dataVolta'];
        return campos.every(c => !validarCampo(c));
    });
    const duracaoDias = computed(() => {
        if (!form.dataIda || !form.dataVolta)
            return 0;
        const diff = new Date(form.dataVolta).getTime() - new Date(form.dataIda).getTime();
        return Math.max(0, Math.ceil(diff / (1000 * 60 * 60 * 24)));
    });
    const hoje = new Date().toISOString().split('T')[0];
    return {
        form,
        errors,
        touched,
        isValido,
        duracaoDias,
        hoje,
        DEPARTAMENTOS,
        DESTINOS_SUGERIDOS,
        onBlur,
        validarTodos,
        resetar,
    };
}
