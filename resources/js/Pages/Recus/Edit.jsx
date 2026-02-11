import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ recu, students }) {
    const form = useForm({
        numero_recu: recu.numero_recu || '',
        montant: recu.montant || '',
        date_paiement: recu.date_paiement || '',
        fichier_pdf: null,
        student_id: recu.student_id || '',
    });

    return (
        <AuthenticatedLayout>
            <Head title="Modifier reçu" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">Modifier reçu</h1>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.post(route('recu-paiements.update', recu.id), { forceFormData: true, _method: 'put' });
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
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Mettre à jour</button>
                        <Link href={route('recu-paiements.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
