import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ recu }) {
    return (
        <AuthenticatedLayout>
            <Head title="Détails reçu" />
            <div className="mx-auto max-w-5xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">Reçu {recu.numero_recu}</h1>
                <div className="bg-white rounded border border-slate-200 p-6 text-sm">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><span className="text-slate-500">Étudiant:</span> {recu.student?.nom} {recu.student?.prenom}</div>
                        <div><span className="text-slate-500">Montant:</span> {recu.montant}</div>
                        <div><span className="text-slate-500">Date:</span> {recu.date_paiement}</div>
                    </div>
                    <div className="pt-4">
                        <Link href={route('recu-paiements.index')} className="text-sm text-slate-600">Retour</Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
