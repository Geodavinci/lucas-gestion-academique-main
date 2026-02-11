import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ students }) {
    const form = useForm({
        numero_recu: '',
        montant: '',
        date_paiement: '',
        fichier_pdf: null,
        student_id: '',
    });

    return (
        <AuthenticatedLayout>
            <Head title="Nouveau reçu" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <h1 className="text-2xl font-semibold">Nouveau reçu</h1>
                    <Link href={route('recu-paiements.index')} className="rounded border border-slate-300 px-3 py-2 text-sm">Retour</Link>
                </div>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.post(route('recu-paiements.store'), { forceFormData: true });
                    }}
                    className="bg-white p-6 rounded border border-slate-200 space-y-4"
                >
                    <div>
                        <label className="block text-sm font-medium">Numéro reçu</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.numero_recu} onChange={(e) => form.setData('numero_recu', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Montant</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.montant} onChange={(e) => form.setData('montant', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Date paiement</label>
                        <input type="date" className="mt-1 w-full rounded border-slate-300" value={form.data.date_paiement} onChange={(e) => form.setData('date_paiement', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Étudiant</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.student_id} onChange={(e) => form.setData('student_id', e.target.value)}>
                            <option value="">Sélectionner</option>
                            {students.map((s) => (
                                <option key={s.id} value={s.id}>{s.nom} {s.prenom}</option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Fichier PDF</label>
                        <input type="file" className="mt-1 w-full rounded border-slate-300 bg-white" onChange={(e) => form.setData('fichier_pdf', e.target.files[0])} />
                    </div>
                    <div className="pt-2">
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
                        <Link href={route('recu-paiements.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
