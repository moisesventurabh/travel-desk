
let modalPedidoId = null;
let modalAcao = null;
let viagensData = null;

let isEdit = false;

function openCreateModal() {
    isEdit = false;
    document.getElementById('form-viagem').reset();
    document.getElementById('viagem-id').value = '';
    document.getElementById('modal-titulo').innerText = 'Novo Pedido de Viagem';
    document.getElementById('modal-viagem').classList.replace('hidden', 'flex');
}

function openEditModal(id) {
    isEdit = true;
    fetch(`/admin/viagens/${id}`)
        .then(res => res.json())
        .then(v => {
            document.getElementById('viagem-id').value = v.id;
            document.getElementById('v-solicitante').value = v.solicitante;
            document.getElementById('v-destino').value = v.destino;
            document.getElementById('v-ida').value = v.data_ida;
            document.getElementById('v-volta').value = v.data_volta;
            document.getElementById('modal-titulo').innerText = `Editar Pedido #VGM-${id}`;
            document.getElementById('modal-viagem').classList.replace('hidden', 'flex');
        });
}

function closeViagemModal() {
    document.getElementById('modal-viagem').classList.replace('flex', 'hidden');
}

document.getElementById('form-viagem').onsubmit = function(e) {
    e.preventDefault();
    const id = document.getElementById('viagem-id').value;
    const url = isEdit ? `/admin/viagens/${id}` : `/admin/viagens`;
    const method = isEdit ? 'PUT' : 'POST';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    const payload = {
        solicitante: document.getElementById('v-solicitante').value,
        origem: document.getElementById('v-origem').value,   // Novo
        destino: document.getElementById('v-destino').value,
        data_ida: document.getElementById('v-ida').value,
        data_volta: document.getElementById('v-volta').value,
    };

    if (!csrfToken) {
        console.error('Token CSRF não encontrado. Verifique se a meta tag existe.');
        return;
    }

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken, // Usa a variável segura
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(() => {
        closeViagemModal();
        window.location.reload(); // Ou chame applyFilters() se estiver em AJAX puro
    });
};

// Exponha as funções globalmente para que os botões do Blade (onclick) continuem funcionando
window.openStatusModal = (id, acao, solicitante, destino) => {
    const modal = document.getElementById('modal-status');
    const title = document.getElementById('modal-title');
    const content = document.getElementById('modal-content');
    
    title.textContent = acao === 'aprovar' ? 'Aprovar Pedido' : 'Cancelar Pedido';
    // Use textContent para evitar injeção de script pelos nomes
    content.textContent = `Deseja ${acao} a viagem de ${solicitante} para ${destino}?`; 
    
    modal.classList.add('open');
};

// Funções de fechar e confirmar...
window.closeModal = () => document.getElementById('modal-status').classList.remove('open');


// 2. Lógica do Modal de Status
function openStatusModal(id, acao, solicitante, destino) {
    modalPedidoId = id;
    modalAcao = acao;
    const isAprovar = acao === 'aprovar';

    document.getElementById('modal-title').textContent = isAprovar ? 'Aprovar Pedido' : 'Cancelar Pedido';
    document.getElementById('modal-sub').textContent = `#VGM-${String(id).padStart(4, '0')} — ${solicitante} → ${destino}`;
    document.getElementById('modal-content').innerHTML = `
        <div class="p-4 rounded-xl ${isAprovar ? 'bg-emerald-50 border border-emerald-200' : 'bg-red-50 border border-red-200'} mb-4">
            <p class="text-sm ${isAprovar ? 'text-emerald-800' : 'text-red-800'}">
                ${isAprovar 
                    ? '✅ Ao aprovar, o solicitante será notificado e o pedido será processado.' 
                    : '⚠️ Ao cancelar, o solicitante será informado da recusa do pedido.'}
            </p>
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Observação (opcional)</label>
            <textarea id="modal-obs" rows="3" placeholder="Justificativa..." class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl resize-none focus:ring-2 focus:ring-sky-500 outline-none transition-all"></textarea>
        </div>`;
    
    document.getElementById('modal-actions').innerHTML = `
        <button onclick="closeModal()" class="flex-1 py-2.5 text-sm font-semibold border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors">Fechar</button>
        <button onclick="confirmStatusChange()" class="flex-1 py-2.5 text-sm font-semibold ${isAprovar ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-red-500 hover:bg-red-600'} text-white rounded-xl shadow-lg transition-colors">
            Confirmar
        </button>`;
    
    document.getElementById('modal-status').classList.add('open');
}

function closeModal() {
    document.getElementById('modal-status').classList.remove('open');
}

function confirmStatusChange() {
    const status = modalAcao === 'aprovar' ? 'aprovado' : 'cancelado';
    const obs = document.getElementById('modal-obs').value;

    fetch(`/admin/viagens/${modalPedidoId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status: status, observacao: obs })
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            closeModal();
            applyFilters();
        }
    })
    .catch(() => alert('Erro na comunicação com o servidor.'));
}



function deleteViagem(id) {
    if (confirm(`Tem certeza que deseja excluir o pedido #VGM-${String(id).padStart(4, '0')}?`)) {
        
        fetch(`/admin/viagens/${id}`, {
            method: 'DELETE',
            headers: {
                // É CRÍTICO que esta meta tag exista no seu layout principal
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Erro na resposta do servidor');
            return res.json();
        })
        .then(data => {
            showToast('✅ Pedido excluído com sucesso!', 'success');
            applyFilters(); // Recarrega a tabela via AJAX
        })
        .catch(err => {
            console.error(err);
            showToast('❌ Erro ao excluir o pedido.', 'error');
        });
    }
}

// Abrir Modal para Edição
function openEditModal(id) {
    // 1. Busca os dados da viagem via AJAX
    fetch(`/admin/viagens/${id}`)
        .then(res => res.json())
        .then(viagem => {
            // 2. Preenche o formulário que você já usa para "Novo Pedido"
            // Nota: Verifique se os IDs dos inputs no seu modal de cadastro batem com estes:
            document.getElementById('np-solicitante').value = viagem.solicitante;
            document.getElementById('np-destino').value = viagem.destino;
            document.getElementById('np-ida').value = viagem.data_ida;
            document.getElementById('np-volta').value = viagem.data_volta;
            
            // Troca o título do modal e o método de envio
            document.getElementById('modal-novo-titulo').textContent = 'Editar Pedido #' + id;
            
            // Armazena o ID para o save
            window.editingId = id;

            // 3. Abre o modal (usando a classe que você já tem para o modal de novo pedido)
            document.getElementById('modal-novo-pedido').classList.add('open');
        });
}

// Visualizar Detalhes (Popup de leitura)
function openDetalhe(id) {
    fetch(`/admin/viagens/${id}`)
        .then(res => res.json())
        .then(v => {
            // Aqui você pode usar o mesmo modal de status ou um novo apenas para ver dados
            const content = `
                <div class="space-y-3 text-sm">
                    <p><strong>Solicitante:</strong> ${v.solicitante}</p>
                    <p><strong>Destino:</strong> ${v.destino}</p>
                    <p><strong>Período:</strong> ${new Date(v.data_ida).toLocaleDateString()} a ${new Date(v.data_volta).toLocaleDateString()}</p>
                    <p><strong>Status:</strong> <span class="badge-${v.status}">${v.status}</span></p>
                </div>
            `;
            document.getElementById('modal-title').textContent = 'Detalhes da Viagem';
            document.getElementById('modal-sub').textContent = '#VGM-' + id;
            document.getElementById('modal-content').innerHTML = content;
            document.getElementById('modal-actions').innerHTML = `<button onclick="closeModal()" class="w-full py-2 bg-slate-100 rounded-xl">Fechar</button>`;
            document.getElementById('modal-status').classList.add('open');
        });
}


function clearFilters() {
    document.getElementById('filter-search').value = '';
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-de').value = '';
    document.getElementById('filter-ate').value = '';
    applyFilters(); // Recarrega a tabela limpa
}

// Filtros e busca (já existentes no seu código)
function applyFilters() {
    const filters = {
        search: document.getElementById('filter-search').value,
        status: document.getElementById('filter-status').value,
        desde: document.getElementById('filter-de').value,
        ate: document.getElementById('filter-ate').value
    };
    const query = new URLSearchParams(filters).toString();

    fetch(`{{ route('viagens.index') }}?${query}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => renderTable(data.viagens.data));

    //viagensData
}

function getStatusClass(status) {
    // Retorna as classes do Tailwind baseadas no status que vem do banco de dados
    switch (status) {
        case 'aprovado':
            return 'bg-emerald-100 text-emerald-700 border border-emerald-200';
        case 'cancelado':
            return 'bg-red-100 text-red-700 border border-red-200';
        case 'solicitado':
            return 'bg-amber-100 text-amber-700 border border-amber-200';
        default:
            return 'bg-slate-100 text-slate-700 border border-slate-200';
    }
}

function renderTable(response) {

    //console.log('> '+response); // Debug: Verifique a estrutura da resposta
    
    const tableBody = document.getElementById('pedidos-tbody'); // Certifique-se que o ID existe no HTML
    
    
    if (!tableBody) return;

    tableBody.innerHTML = '';

    /*
    // Verifica se a resposta e a propriedade viagens existem
    if (!response || !response.viagens || !response.viagens.data) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Nenhum resultado encontrado.</td></tr>';
        return;
    }
    */

    const data = response; // Acessa os dados da paginação

    //console.log('-> '+data); // Debug: Verifique os dados que estão sendo processados

    data.forEach(viagem => {
    // Dentro do seu data.forEach(viagem => { ... })
    const row = `
        <tr class="${viagem.enabled === 0 ? 'opacity-50 grayscale bg-slate-50' : ''}">
            <td class="px-5 py-3">
                <p class="font-mono text-xs font-semibold text-slate-400">#VGM-${viagem.id.toString().padStart(4, '0')}</p>
                <p class="text-md font-medium text-slate-700">${viagem.solicitante}</p>
            </td>

            <td class="px-5 py-3.5 text-sm text-slate-600">${viagem.origem} → ${viagem.destino}</td>
            <td class="px-5 py-3.5 text-xs text-slate-500 hidden md:table-cell">${new Date(viagem.data_ida).toLocaleDateString('pt-BR')}</td>
            <td class="px-5 py-3.5 text-xs text-slate-500 hidden md:table-cell">${new Date(viagem.data_volta).toLocaleDateString('pt-BR')}</td>

            <td class="px-4 py-3">
                <span class="px-2 py-1 rounded-full text-xs font-medium border ${getStatusClass(viagem.status)}">
                    ${viagem.status}
                </span>
            </td>

            <td class="px-4 py-3 text-right">
                <div class="flex items-center justify-center gap-1.5">
                    
                    <button title="Ver detalhes" onclick="openDetalhe(${viagem.id})" class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-500 hover:border-sky-400 hover:text-sky-500 hover:bg-sky-50 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                
                    <button title="Aprovar" 
                        onclick="openStatusModal(${viagem.id}, 'aprovar', '${viagem.solicitante}', '${viagem.destino}')" 
                        class="w-7 h-7 rounded-lg border flex items-center justify-center transition-all 
                        ${viagem.status === 'aprovado' 
                            ? 'bg-emerald-50 border-emerald-400 text-emerald-500 shadow-sm' 
                            : 'bg-white border-slate-200 text-slate-500 hover:border-emerald-400 hover:text-emerald-500 hover:bg-emerald-50' 
                        }">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M4.5 12.75l6 6 9-13.5"></path>
                        </svg>
                    </button>

                    <button title="Cancelar" 
                        onclick="openStatusModal(${viagem.id}, 'cancelar', '${viagem.solicitante}', '${viagem.destino}')" 
                        class="w-7 h-7 rounded-lg border flex items-center justify-center transition-all 
                        ${viagem.status === 'cancelado' 
                            ? 'bg-red-50 border-red-400 text-red-500 shadow-sm' 
                            : 'bg-white border-slate-200 text-slate-500 hover:border-red-400 hover:text-red-500 hover:bg-red-50' 
                        }">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <button title="Excluir" onclick="deleteViagem(${viagem.id})" class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-500 hover:border-red-600 hover:text-red-600 hover:bg-red-50 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>

                </div>
            </td>
        </tr>
    `;
        tableBody.insertAdjacentHTML('beforeend', row);
    });
}
