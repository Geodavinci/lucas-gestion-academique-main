import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ soutenance }) {
    return (
        <AuthenticatedLayout>
            <Head title="Détails soutenance" />
            <div className="mx-auto max-w-5xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">Soutenance</h1>

                <div className="bg-white rounded border border-slate-200 p-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div><span className="text-slate-500">Date:</span> {soutenance.date_soutenance}</div>
                        <div><span className="text-slate-500">Statut:</span> {soutenance.statut}</div>
                        <div><span className="text-slate-500">Étudiant:</span> {soutenance.student?.nom} {soutenance.student?.prenom}</div>
                        <div><span className="text-slate-500">Directeur:</span> {soutenance.directeur_memoire?.nom} {soutenance.directeur_memoire?.prenom}</div>
                        <div><span className="text-slate-500">Évaluateur:</span> {soutenance.evaluateur_teacher?.nom} {soutenance.evaluateur_teacher?.prenom}</div>
                        <div><span className="text-slate-500">Président:</span> {soutenance.president_jury?.nom} {soutenance.president_jury?.prenom}</div>
                        <div className="md:col-span-2"><span className="text-slate-500">Description:</span> {soutenance.description}</div>
                    </div>
                    <div className="pt-4">
                        <Link href={route('soutenances.index')} className="text-sm text-slate-600">Retour</Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
