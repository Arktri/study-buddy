<?php

class NoteController extends \BaseController {

    public function getAllModuleNotes($id) {
        $module = Module::find($id);

        return View::make('module/moduleNotes', compact('module'));
    }

    // show view for an individual note
    public function showIndividualNote($id, $noteID) {
        $module = Module::find($id);
        $selectedNote = $module->notes->find($noteID);

        return View::make('module/individualModuleNote', compact('module', 'selectedNote'));
    }

    public function show($id)
    {
        
    }

    public function json($id) {
        return Note::find($id);
    }

    // updates an already existing note
    public function update($id) {

        $note = Note::find($id);
        $date = new \DateTime; // used to manually update created_at

        $noteData = Input::only(
            'note_title',
            'note_body',
            'note_tags',
            'is_public'
        );


        // $noteData = array_map("htmlentities", $noteData);

        $validator = Validator::make($noteData, [
            'note_title' => 'required',
            'note_body' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json($validator->messages(), 400);
        }
        else {
            $note->update($noteData);
            return $note;
        }
    }

    // get new public notes since x time
    public function getNewPublic($id) {
        $date = new DateTime;
        $date->modify('-30 seconds');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $recentPublicNotes = Note::where('updated_at','>=', $formatted_date)
            ->where('module_id', $id)
            ->get();

        foreach($recentPublicNotes as $note) {
            $note['diffForHumans'] = $note->updated_at->diffForHumans();
        }

        return $recentPublicNotes;
    }

    // delete the note from the db
    public function delete($id) {
        $note = Note::destroy($id);

        return $id;
    }

    // store the new note in the database
    public function store() {
        $date = new \DateTime; // used to manually update created_at

        $noteData = Input::only(
            'note_title',
            'note_body',
            'note_tags',
            'is_public',
            'module_id',
            'user_id'
        );

        // $noteData = array_map("htmlentities", $noteData);

        $validator = Validator::make($noteData, [
            'note_title' => 'required',
            'note_body' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json($validator->messages(), 400);
        }
        else {
            $note = Note::create($noteData);
            return $note;
        }
    }

    public function search($id) {
        $tags = Input::get('note_tags');

        // $notes = DB::table('notes')
            $notes = Note::where('user_id', '=', Auth::user()->id)
                        ->where('module_id', '=', $id)
                        ->where('note_tags', 'LIKE', '%' . $tags . '%')
                        ->get();

        return $notes;
    }
}
