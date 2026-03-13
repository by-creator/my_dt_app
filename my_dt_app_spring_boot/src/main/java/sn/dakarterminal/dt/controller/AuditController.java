package sn.dakarterminal.dt.controller;

import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/audit")
@RequiredArgsConstructor
@PreAuthorize("hasAnyRole('ADMIN', 'SUPER_U')")
public class AuditController {

    @GetMapping("/logs")
    public ResponseEntity<List<Map<String, Object>>> getLogs(
            @RequestParam(required = false) String user,
            @RequestParam(required = false) String action,
            @RequestParam(required = false) String entityType) {
        // In a real app, audit logs would be stored in DB or ELK stack
        return ResponseEntity.ok(List.of(
                Map.of("message", "Audit logs are available in application logs file")
        ));
    }
}
